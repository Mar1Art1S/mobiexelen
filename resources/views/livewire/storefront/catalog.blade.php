<section class="products" id="catalog" aria-labelledby="products-heading">
    <div class="section-heading">
        <div class="section-title">
            <span class="section-icon" aria-hidden="true">✣</span>
            <div>
                <p>{{ $catalogPage ? 'Каталог продукції' : 'Обране пасічниками' }}</p>
                <h2 id="products-heading">{{ $category === 'all' ? ($catalogPage ? 'Усі товари' : 'Популярні товари') : $this->categoryLabel }}</h2>
            </div>
        </div>
        @unless ($catalogPage)
            <button type="button" wire:click="toggleShowAll">{{ $showAll ? 'Згорнути' : 'Дивитись всі' }} <span>{{ $showAll ? '↑' : '→' }}</span></button>
        @endunless
    </div>

    @if ($catalogPage || $category !== 'all' || $search !== '')
        <div class="active-filter" wire:transition>
            <strong>{{ $this->categoryLabel }}</strong> · Знайдено: {{ $total }}
            @if ($search !== '')<span>«{{ $search }}»</span>@endif
        </div>
    @endif

    <div class="product-grid">
        @forelse ($products as $product)
            <livewire:storefront.product-card :product="$product" :key="'product-'.$product['id']" />
        @empty
            <div class="empty-state">
                <span>⌕</span><strong>Нічого не знайшли</strong><small>Спробуйте інший запит або категорію</small>
            </div>
        @endforelse
    </div>
</section>
