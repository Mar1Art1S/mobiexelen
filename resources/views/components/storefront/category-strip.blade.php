@php
    $categories = [
        ['all', '▦', 'Усі товари'],
        ['hives', '⬡', 'Готові комплекти'],
        ['bodies', '▱', 'Корпуси'],
        ['bottoms', '▰', 'Дно'],
        ['roofs', '▬', 'Кришки'],
        ['frames', '▥', 'Рамки та комплектуючі'],
        ['tools', '♨', 'Аксесуари'],
    ];
@endphp

<div
    class="category-navigation"
    :class="{ 'is-compact': compact }"
    x-data="categoryScroller()"
    @catalog-search.window="syncSearch($event.detail.search)"
    @cart-count-changed.window="cartCount = Number($event.detail.count ?? 0)"
>
    <div class="category-compact-tools" x-show="compact" x-cloak>
        <form class="category-compact-search" role="search" @submit.prevent>
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="11" cy="11" r="6.5" />
                <path d="m16 16 4 4" />
            </svg>
            <input
                type="search"
                placeholder="Пошук товарів"
                aria-label="Пошук товарів"
                x-model="search"
                @input.debounce.250ms="searchCatalog()"
            >
            <button
                type="button"
                aria-label="Очистити пошук"
                x-show="search.length"
                @click="search = ''; searchCatalog()"
            >×</button>
        </form>

        <button
            class="category-compact-cart"
            type="button"
            aria-label="Відкрити кошик"
            @click="openCart()"
        >
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M3 4h2l1.6 10.2h10.8l2-7.2H6" />
                <circle cx="9" cy="19" r="1.2" />
                <circle cx="17" cy="19" r="1.2" />
            </svg>
            <em x-show="cartCount > 0" x-text="cartCount"></em>
        </button>
    </div>

    <section
        class="category-strip"
        :class="{ 'is-dragging': dragging }"
        aria-label="Категорії товарів"
        tabindex="0"
        x-ref="categories"
        @wheel="handleWheel($event)"
        @pointerdown="startDrag($event)"
        @pointermove="drag($event)"
        @pointerup="endDrag($event)"
        @pointercancel="endDrag($event)"
        @keydown.right.prevent="$el.scrollBy({ left: 100, behavior: 'smooth' })"
        @keydown.left.prevent="$el.scrollBy({ left: -100, behavior: 'smooth' })"
    >
        @foreach ($categories as [$key, $symbol, $label])
            <button
                class="category-card"
                :class="{ active: active === '{{ $key }}' }"
                type="button"
                @click="selectCategory($event, '{{ $key }}')"
            >
                <span class="category-art category-{{ $key }}" aria-hidden="true">
                    <b>{{ $symbol }}</b>
                </span>
                <small>{{ $label }}</small>
            </button>
        @endforeach
    </section>
</div>
