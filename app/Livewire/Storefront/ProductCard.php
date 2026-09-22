<?php

namespace App\Livewire\Storefront;

use Livewire\Attributes\On;
use Livewire\Component;

class ProductCard extends Component
{
    public array $product = [];

    public int $quantity = 0;

    public bool $favorite = false;

    public function mount(array $product): void
    {
        $this->product = $product;
        $this->quantity = (int) (session('storefront.cart', [])[$product['id']] ?? 0);
        $this->favorite = in_array($product['id'], session('storefront.favorites', []), true);
    }

    public function addToCart(): void
    {
        $cart = session('storefront.cart', []);
        $cart[$this->product['id']] = ($cart[$this->product['id']] ?? 0) + 1;
        session()->put('storefront.cart', $cart);

        $this->quantity = $cart[$this->product['id']];
        $this->dispatch('cart-count-changed', count: array_sum($cart));
        $this->dispatch('store-toast', message: 'Товар додано до кошика');
    }

    public function decrementCart(): void
    {
        $cart = session('storefront.cart', []);
        $productId = $this->product['id'];

        if (! isset($cart[$productId])) {
            return;
        }

        if ($cart[$productId] <= 1) {
            unset($cart[$productId]);
            $this->quantity = 0;
            $message = 'Товар видалено з кошика';
        } else {
            $cart[$productId]--;
            $this->quantity = $cart[$productId];
            $message = 'Кількість товару зменшено';
        }

        session()->put('storefront.cart', $cart);
        $this->dispatch('cart-count-changed', count: array_sum($cart));
        $this->dispatch('store-toast', message: $message);
    }

    #[On('cart-item-changed')]
    public function syncCartQuantity(int $productId, int $quantity): void
    {
        if ((int) $this->product['id'] === $productId) {
            $this->quantity = $quantity;
        }
    }

    public function toggleFavorite(): void
    {
        $favorites = session('storefront.favorites', []);
        $productId = $this->product['id'];

        if (in_array($productId, $favorites, true)) {
            $favorites = array_values(array_diff($favorites, [$productId]));
            $this->favorite = false;
            $message = 'Видалено з обраного';
        } else {
            $favorites[] = $productId;
            $this->favorite = true;
            $message = 'Додано в обране';
        }

        session()->put('storefront.favorites', $favorites);
        $this->dispatch('favorite-count-changed', count: count($favorites));
        $this->dispatch('store-toast', message: $message);
    }

    public function render()
    {
        $unitPrice = (int) str_replace(' ', '', $this->product['price']);

        return view('livewire.storefront.product-card', [
            'displayPrice' => $unitPrice * max(1, $this->quantity),
        ]);
    }
}
