<?php

namespace Tests\Feature;

use App\Livewire\Storefront\Catalog;
use App\Livewire\Storefront\Header;
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
            ->assertSee('Медогонки');
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
            ->assertSee('Вулик ППУ 10-рамковий')
            ->assertDontSee('Кришка ППУ з вентиляцією');
    }

    public function test_it_updates_favorites_and_cart_state(): void
    {
        Livewire::test(Catalog::class)
            ->call('toggleFavorite', 1)
            ->assertSet('favorites', [1])
            ->assertDispatched('favorite-count-changed', count: 1)
            ->call('addToCart', 1)
            ->assertSet('cart.1', 1)
            ->assertDispatched('cart-count-changed', count: 1);
    }

    public function test_it_updates_header_search_and_counters(): void
    {
        Livewire::test(Header::class)
            ->set('search', 'вулик')
            ->assertDispatched('catalog-search', search: 'вулик')
            ->dispatch('cart-count-changed', count: 2)
            ->assertSet('cartCount', 2);
    }
}
