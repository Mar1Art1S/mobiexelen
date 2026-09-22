<?php

namespace Tests\Feature;

use App\Livewire\Storefront\CartModal;
use App\Livewire\Storefront\Catalog;
use App\Livewire\Storefront\Header;
use App\Livewire\Storefront\ProductCard;
use App\Mail\StorefrontOrderPlaced;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class StorefrontTest extends TestCase
{
    public function test_it_renders_the_mobile_storefront(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Beehive')
            ->assertSee('Популярні товари');
    }

    public function test_it_renders_the_catalog_category_page(): void
    {
        $this->get('/catalog')
            ->assertOk()
            ->assertSee('Каталог категорій')
            ->assertSee('Готові вулики')
            ->assertSee('Медогонки')
            ->assertSee('Усі товари')
            ->assertSee(route('shop.category', ['category' => 'hives']), escape: false);
    }

    public function test_it_renders_the_modular_tips_page(): void
    {
        $this->get('/tips')
            ->assertOk()
            ->assertSee('Відеоматеріали та інструкції')
            ->assertSee('PDF Інструкції &amp; Збірка', escape: false)
            ->assertSee('Розміри 8-рамкового вулика Дадан')
            ->assertSee('Інструкція для 12-рамкового вулика');
    }

    public function test_it_opens_a_catalog_category_from_the_query_string(): void
    {
        $this->get('/?category=hives')
            ->assertOk()
            ->assertSee('Вулик ППУ 10-рамковий')
            ->assertDontSee('Кришка ППУ з вентиляцією');
    }

    public function test_it_filters_the_catalog_without_a_page_reload(): void
    {
        Livewire::test(Catalog::class)
            ->dispatch('category-selected', category: 'hives')
            ->assertSet('category', 'hives')
            ->assertViewHas('products', fn ($products) => $products->count() === 3
                && $products->every(fn ($product) => $product['category'] === 'hives'));
    }

    public function test_catalog_page_shows_all_products_for_the_selected_category(): void
    {
        Livewire::test(Catalog::class, ['catalogPage' => true])
            ->assertSet('showAll', true)
            ->dispatch('category-selected', category: 'frames')
            ->assertSet('category', 'frames')
            ->assertSet('showAll', true)
            ->assertViewHas('products', fn ($products) => $products->count() === 3
                && $products->every(fn ($product) => $product['category'] === 'frames'));
    }

    public function test_it_opens_a_dedicated_shop_page_for_a_category(): void
    {
        $this->get('/shop/hives')
            ->assertOk()
            ->assertSee('Готові вулики')
            ->assertSee('Знайдено: 3')
            ->assertSee('Вулик ППУ 10-рамковий')
            ->assertSee('Вулик ППУ 8-рамковий')
            ->assertDontSee('Кришка ППУ з вентиляцією');
    }

    public function test_it_rejects_an_unknown_shop_category(): void
    {
        $this->get('/shop/unknown')->assertNotFound();
    }

    public function test_it_updates_favorites_and_cart_state(): void
    {
        $product = [
            'id' => 1,
            'name' => 'Вулик ППУ 10-рамковий',
            'price' => '4 200',
            'category' => 'hives',
            'tag' => 'Хіт',
            'type' => 'hive-blue',
        ];

        Livewire::test(ProductCard::class, ['product' => $product])
            ->call('toggleFavorite')
            ->assertSet('favorite', true)
            ->assertDispatched('favorite-count-changed', count: 1)
            ->call('addToCart')
            ->assertSet('quantity', 1)
            ->assertDispatched('cart-count-changed', count: 1)
            ->assertSee('Кількість: 1')
            ->call('addToCart')
            ->assertSet('quantity', 2)
            ->assertDispatched('cart-count-changed', count: 2)
            ->assertSee('8 400 грн')
            ->call('decrementCart')
            ->assertSet('quantity', 1)
            ->assertSee('4 200 грн')
            ->call('decrementCart')
            ->assertSet('quantity', 0)
            ->assertDispatched('cart-count-changed', count: 0)
            ->assertSee('У кошик');

        $this->assertSame([], session('storefront.cart'));
        $this->assertSame([1], session('storefront.favorites'));
    }

    public function test_it_updates_header_search_and_counters(): void
    {
        Livewire::test(Header::class)
            ->set('search', 'вулик')
            ->assertDispatched('catalog-search', search: 'вулик')
            ->dispatch('cart-count-changed', count: 2)
            ->assertSet('cartCount', 2);
    }

    public function test_cart_modal_displays_session_items_and_total(): void
    {
        $this->withSession([
            'storefront.cart' => [2 => 3, 8 => 1],
        ]);

        Livewire::test(CartModal::class)
            ->call('openCart')
            ->assertSet('open', true)
            ->assertSet('count', 4)
            ->assertSet('total', 4850)
            ->assertSee('Корпус ППУ 10-рамковий')
            ->assertSee('Магазинна надставка ППУ')
            ->assertSee('4 850 грн')
            ->call('closeCart')
            ->assertSet('open', false);
    }

    public function test_cart_modal_updates_item_quantities_and_totals(): void
    {
        $this->withSession([
            'storefront.cart' => [2 => 3, 8 => 1],
        ]);

        Livewire::test(CartModal::class)
            ->call('openCart')
            ->call('increment', 2)
            ->assertSet('count', 5)
            ->assertSet('total', 6100)
            ->assertDispatched('cart-count-changed', count: 5)
            ->assertDispatched('cart-item-changed', productId: 2, quantity: 4)
            ->call('decrement', 8)
            ->assertSet('count', 4)
            ->assertSet('total', 5000)
            ->assertDispatched('cart-count-changed', count: 4)
            ->assertDispatched('cart-item-changed', productId: 8, quantity: 0)
            ->assertDontSee('Магазинна надставка ППУ');

        $this->assertSame([2 => 4], session('storefront.cart'));
    }

    public function test_checkout_sends_an_order_email_and_clears_the_cart(): void
    {
        Mail::fake();

        $this->withSession([
            'storefront.cart' => [2 => 2, 8 => 1],
        ]);

        Livewire::test(CartModal::class)
            ->call('openCart')
            ->call('beginCheckout')
            ->assertSet('step', 'checkout')
            ->set('customerName', 'Олександр')
            ->set('customerPhone', '+38 050 123 45 67')
            ->set('customerEmail', 'client@example.com')
            ->set('deliveryMethod', 'Нова пошта')
            ->set('city', 'Кременчук')
            ->set('deliveryAddress', 'Відділення №5')
            ->set('comment', 'Зателефонуйте перед відправленням.')
            ->call('submitOrder')
            ->assertHasNoErrors()
            ->assertSet('step', 'success')
            ->assertSet('count', 0)
            ->assertSet('total', 0)
            ->assertDispatched('cart-count-changed', count: 0);

        Mail::assertSent(StorefrontOrderPlaced::class, function (StorefrontOrderPlaced $mail): bool {
            return $mail->hasTo(config('storefront.order_email'))
                && $mail->order['customer_name'] === 'Олександр'
                && $mail->order['count'] === 3
                && $mail->order['total'] === 3600;
        });

        $this->assertSame([], session('storefront.cart', []));
    }

    public function test_checkout_validates_required_fields(): void
    {
        $this->withSession([
            'storefront.cart' => [2 => 1],
        ]);

        Livewire::test(CartModal::class)
            ->call('openCart')
            ->call('beginCheckout')
            ->call('submitOrder')
            ->assertHasErrors(['customerName', 'customerPhone', 'city', 'deliveryAddress']);
    }

    public function test_cart_modal_has_an_empty_state(): void
    {
        Livewire::test(CartModal::class)
            ->call('openCart')
            ->assertSee('Кошик поки порожній');
    }
}
