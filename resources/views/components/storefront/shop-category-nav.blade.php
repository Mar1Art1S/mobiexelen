@props(['active' => 'all'])

@php
    $categories = [
        ['all', '▦', 'Усі товари'],
        ['hives', '⬡', 'Вулики'],
        ['bodies', '▱', 'Корпуси'],
        ['bottoms', '▰', 'Дно'],
        ['roofs', '▬', 'Кришки'],
        ['frames', '▥', 'Рамки'],
        ['tools', '♨', 'Аксесуари'],
    ];
@endphp

<nav class="shop-category-nav" aria-label="Категорії магазину">
    @foreach ($categories as [$key, $symbol, $label])
        <a
            class="shop-category-link {{ $active === $key ? 'is-active' : '' }}"
            href="{{ route('shop.category', ['category' => $key]) }}"
            wire:navigate
            @if ($active === $key) aria-current="page" @endif
        >
            <span aria-hidden="true">{{ $symbol }}</span>
            <small>{{ $label }}</small>
        </a>
    @endforeach
</nav>
