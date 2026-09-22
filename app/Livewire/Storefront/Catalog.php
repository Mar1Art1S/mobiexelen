<?php

namespace App\Livewire\Storefront;

use App\Support\StorefrontProducts;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class Catalog extends Component
{
    public string $category = 'all';

    public string $search = '';

    public bool $showAll = false;

    public bool $catalogPage = false;

    public function mount(bool $catalogPage = false, ?string $initialCategory = null): void
    {
        $this->catalogPage = $catalogPage;
        $this->showAll = $catalogPage;

        $requestedCategory = $initialCategory ?? request()->query('category');

        if (is_string($requestedCategory) && array_key_exists($requestedCategory, $this->categories())) {
            $this->category = $requestedCategory;
            $this->showAll = true;
        }
    }

    #[On('category-selected')]
    public function selectCategory(string $category): void
    {
        $this->category = array_key_exists($category, $this->categories()) ? $category : 'all';
        $this->showAll = $this->catalogPage;
    }

    #[On('catalog-search')]
    public function updateSearch(string $search): void
    {
        $this->search = trim($search);
        $this->showAll = true;
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

    public function getCategoryLabelProperty(): string
    {
        return $this->categories()[$this->category] ?? $this->categories()['all'];
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
        return StorefrontProducts::all();
    }

    private function categories(): array
    {
        return [
            'all' => 'Усі товари',
            'hives' => 'Готові вулики',
            'bodies' => 'Корпуси',
            'bottoms' => 'Дно',
            'roofs' => 'Кришки',
            'frames' => 'Рамки',
            'tools' => 'Інструменти та аксесуари',
        ];
    }
}
