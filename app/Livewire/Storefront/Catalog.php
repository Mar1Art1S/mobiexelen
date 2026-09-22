<?php

namespace App\Livewire\Storefront;

use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class Catalog extends Component
{
    public string $category = 'all';

    public string $search = '';

    public array $cart = [];

    public array $favorites = [];

    public bool $showAll = false;

    public function mount(): void
    {
        $requestedCategory = request()->query('category');
        $availableCategories = ['all', 'hives', 'bodies', 'bottoms', 'roofs', 'frames', 'tools'];

        if (is_string($requestedCategory) && in_array($requestedCategory, $availableCategories, true)) {
            $this->category = $requestedCategory;
            $this->showAll = true;
        }
    }

    #[On('category-selected')]
    public function selectCategory(string $category): void
    {
        $this->category = $category;
        $this->showAll = false;
    }

    #[On('catalog-search')]
    public function updateSearch(string $search): void
    {
        $this->search = trim($search);
        $this->showAll = true;
    }

    public function toggleFavorite(int $productId): void
    {
        if (in_array($productId, $this->favorites, true)) {
            $this->favorites = array_values(array_diff($this->favorites, [$productId]));
            $message = 'Видалено з обраного';
        } else {
            $this->favorites[] = $productId;
            $message = 'Додано в обране';
        }

        $this->dispatch('favorite-count-changed', count: count($this->favorites));
        $this->dispatch('store-toast', message: $message);
    }

    public function addToCart(int $productId): void
    {
        $this->cart[$productId] = ($this->cart[$productId] ?? 0) + 1;
        $this->dispatch('cart-count-changed', count: array_sum($this->cart));
        $this->dispatch('store-toast', message: 'Товар додано до кошика');
    }

    public function toggleShowAll(): void
    {
        $this->showAll = ! $this->showAll;
    }

    public function getFilteredProductsProperty(): Collection
    {
        return collect($this->products())
            ->when($this->category !== 'all', fn (Collection $products) => $products->where('category', $this->category))
            ->when($this->search !== '', fn (Collection $products) => $products->filter(
                fn (array $product) => str_contains(mb_strtolower($product['name']), mb_strtolower($this->search))
            ));
    }

    public function render()
    {
        $products = $this->filteredProducts;

        return view('livewire.storefront.catalog', [
            'products' => $this->showAll ? $products : $products->take(4),
            'total' => $products->count(),
        ]);
    }

    private function products(): array
    {
        return [
            ['id' => 1, 'name' => 'Вулик ППУ 10-рамковий', 'price' => '4 200', 'category' => 'hives', 'tag' => 'Хіт', 'type' => 'hive-blue'],
            ['id' => 2, 'name' => 'Корпус ППУ 10-рамковий', 'price' => '1 250', 'category' => 'bodies', 'tag' => '-10%', 'type' => 'box-yellow'],
            ['id' => 3, 'name' => 'Кришка ППУ з вентиляцією', 'price' => '650', 'category' => 'roofs', 'tag' => '', 'type' => 'lid-gray'],
            ['id' => 4, 'name' => 'Рамка дерев’яна 300 мм', 'price' => '350', 'category' => 'frames', 'tag' => '', 'type' => 'frame-wood'],
            ['id' => 5, 'name' => 'Дно ППУ гігієнічне', 'price' => '790', 'category' => 'bottoms', 'tag' => 'Новинка', 'type' => 'bottom-gray'],
            ['id' => 6, 'name' => 'Набір пасічних інструментів', 'price' => '980', 'category' => 'tools', 'tag' => '', 'type' => 'tools-set'],
            ['id' => 7, 'name' => 'Вулик ППУ 12-рамковий', 'price' => '4 850', 'category' => 'hives', 'tag' => 'Хіт', 'type' => 'hive-yellow'],
            ['id' => 8, 'name' => 'Магазинна надставка ППУ', 'price' => '1 100', 'category' => 'bodies', 'tag' => '', 'type' => 'box-blue'],
        ];
    }
}
