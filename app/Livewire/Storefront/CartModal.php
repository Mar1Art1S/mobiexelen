<?php

namespace App\Livewire\Storefront;

use App\Mail\StorefrontOrderPlaced;
use App\Support\StorefrontProducts;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;
use Throwable;

class CartModal extends Component
{
    public bool $open = false;

    public array $items = [];

    public int $total = 0;

    public int $count = 0;

    public string $step = 'cart';

    public string $customerName = '';

    public string $customerPhone = '';

    public string $customerEmail = '';

    public string $deliveryMethod = 'Нова пошта';

    public string $city = '';

    public string $deliveryAddress = '';

    public string $comment = '';

    public string $website = '';

    public function openCart(): void
    {
        $this->loadCart();
        $this->step = 'cart';
        $this->resetValidation();
        $this->open = true;
    }

    public function closeCart(): void
    {
        $this->open = false;
    }

    public function beginCheckout(): void
    {
        $this->loadCart();

        if ($this->items === []) {
            return;
        }

        $this->resetValidation();
        $this->step = 'checkout';
    }

    public function backToCart(): void
    {
        $this->resetValidation();
        $this->step = 'cart';
    }

    public function submitOrder(): void
    {
        $this->loadCart();

        if ($this->items === []) {
            $this->step = 'cart';

            return;
        }

        if ($this->website !== '') {
            $this->completeOrder();

            return;
        }

        $rateLimitKey = 'storefront-order:'.request()->ip();

        if (RateLimiter::tooManyAttempts($rateLimitKey, 3)) {
            $this->addError('order', 'Забагато спроб. Будь ласка, повторіть трохи пізніше.');

            return;
        }

        $validated = $this->validate($this->checkoutRules(), $this->checkoutMessages());
        $order = [
            'customer_name' => trim($validated['customerName']),
            'customer_phone' => trim($validated['customerPhone']),
            'customer_email' => filled($validated['customerEmail'] ?? null) ? trim($validated['customerEmail']) : null,
            'delivery_method' => $validated['deliveryMethod'],
            'city' => trim($validated['city']),
            'delivery_address' => trim($validated['deliveryAddress']),
            'comment' => filled($validated['comment'] ?? null) ? trim($validated['comment']) : null,
            'items' => $this->items,
            'count' => $this->count,
            'total' => $this->total,
            'submitted_at' => now(),
        ];

        try {
            Mail::to(config('storefront.order_email'))->send(new StorefrontOrderPlaced($order));
        } catch (Throwable $exception) {
            report($exception);
            $this->addError('order', 'Не вдалося надіслати замовлення. Перевірте з’єднання та спробуйте ще раз.');

            return;
        }

        RateLimiter::hit($rateLimitKey, 60);
        $this->completeOrder();
    }

    public function increment(int $productId): void
    {
        $cart = session('storefront.cart', []);

        if (! array_key_exists($productId, $cart)) {
            return;
        }

        $cart[$productId] = (int) $cart[$productId] + 1;
        $this->saveCart($cart, $productId);
    }

    public function decrement(int $productId): void
    {
        $cart = session('storefront.cart', []);

        if (! array_key_exists($productId, $cart)) {
            return;
        }

        if ((int) $cart[$productId] <= 1) {
            unset($cart[$productId]);
        } else {
            $cart[$productId] = (int) $cart[$productId] - 1;
        }

        $this->saveCart($cart, $productId);
    }

    private function saveCart(array $cart, int $productId): void
    {
        session()->put('storefront.cart', $cart);
        $this->loadCart();

        $quantity = (int) ($cart[$productId] ?? 0);
        $this->dispatch('cart-count-changed', count: $this->count);
        $this->dispatch('cart-item-changed', productId: $productId, quantity: $quantity);
    }

    private function completeOrder(): void
    {
        $productIds = array_column($this->items, 'id');

        session()->forget('storefront.cart');
        $this->items = [];
        $this->count = 0;
        $this->total = 0;
        $this->step = 'success';
        $this->dispatch('cart-count-changed', count: 0);

        foreach ($productIds as $productId) {
            $this->dispatch('cart-item-changed', productId: (int) $productId, quantity: 0);
        }

        $this->reset(['customerName', 'customerPhone', 'customerEmail', 'city', 'deliveryAddress', 'comment', 'website']);
    }

    private function checkoutRules(): array
    {
        return [
            'customerName' => ['required', 'string', 'min:2', 'max:80'],
            'customerPhone' => ['required', 'string', 'min:10', 'max:30', 'regex:/^[0-9+()\-\s]+$/'],
            'customerEmail' => ['nullable', 'email:rfc', 'max:160'],
            'deliveryMethod' => ['required', 'in:Нова пошта,Укрпошта,Самовивіз'],
            'city' => ['required', 'string', 'min:2', 'max:100'],
            'deliveryAddress' => ['required', 'string', 'min:2', 'max:180'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ];
    }

    private function checkoutMessages(): array
    {
        return [
            'customerName.required' => 'Вкажіть ваше ім’я.',
            'customerName.min' => 'Ім’я має містити щонайменше 2 символи.',
            'customerPhone.required' => 'Вкажіть номер телефону.',
            'customerPhone.min' => 'Перевірте номер телефону.',
            'customerPhone.regex' => 'Використовуйте лише цифри та символи + ( ) -.',
            'customerEmail.email' => 'Вкажіть коректну електронну адресу.',
            'deliveryMethod.required' => 'Оберіть спосіб доставки.',
            'deliveryMethod.in' => 'Оберіть доступний спосіб доставки.',
            'city.required' => 'Вкажіть населений пункт.',
            'city.min' => 'Назва населеного пункту надто коротка.',
            'deliveryAddress.required' => 'Вкажіть відділення або адресу доставки.',
            'deliveryAddress.min' => 'Уточніть відділення або адресу доставки.',
        ];
    }

    private function loadCart(): void
    {
        $cart = session('storefront.cart', []);
        $products = collect(StorefrontProducts::all())->keyBy('id');

        $this->items = collect($cart)
            ->map(function ($quantity, $productId) use ($products) {
                $product = $products->get((int) $productId);

                if (! $product) {
                    return null;
                }

                $unitPrice = (int) str_replace(' ', '', $product['price']);

                return [
                    ...$product,
                    'quantity' => (int) $quantity,
                    'subtotal' => $unitPrice * (int) $quantity,
                ];
            })
            ->filter()
            ->values()
            ->all();

        $this->count = array_sum($cart);
        $this->total = array_sum(array_column($this->items, 'subtotal'));
    }

    public function render()
    {
        return view('livewire.storefront.cart-modal');
    }
}
