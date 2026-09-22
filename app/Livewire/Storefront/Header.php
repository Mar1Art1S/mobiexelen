<?php

namespace App\Livewire\Storefront;

use Livewire\Attributes\On;
use Livewire\Component;

class Header extends Component
{
    public int $cartCount = 0;

    public int $favoriteCount = 0;

    public string $search = '';

    public function updatedSearch(): void
    {
        $this->dispatch('catalog-search', search: $this->search);
    }

    #[On('catalog-search')]
    public function syncSearch(string $search = ''): void
    {
        $this->search = $search;
    }

    #[On('cart-count-changed')]
    public function updateCartCount(int $count): void
    {
        $this->cartCount = $count;
    }

    #[On('favorite-count-changed')]
    public function updateFavoriteCount(int $count): void
    {
        $this->favoriteCount = $count;
    }

    public function render()
    {
        return view('livewire.storefront.header');
    }
}
