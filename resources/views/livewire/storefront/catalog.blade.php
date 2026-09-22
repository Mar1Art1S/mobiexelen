<section class="products" id="catalog" aria-labelledby="products-heading">
    <div class="section-heading">
        <div class="section-title">
            <span class="section-icon" aria-hidden="true">✣</span>
            <div><p>Обране пасічниками</p><h2 id="products-heading">Популярні товари</h2></div>
        </div>
        <button type="button" wire:click="toggleShowAll">{{ $showAll ? 'Згорнути' : 'Дивитись всі' }} <span>{{ $showAll ? '↑' : '→' }}</span></button>
    </div>

    @if ($category !== 'all' || $search !== '')
        <div class="active-filter" wire:transition>
            Знайдено: {{ $total }}
            @if ($search !== '')<span>«{{ $search }}»</span>@endif
        </div>
    @endif

    <div class="product-grid" wire:loading.class="is-loading">
        @forelse ($products as $product)
            <article class="product-card" wire:key="product-{{ $product['id'] }}">
                <div class="product-visual">
                    @if ($product['tag'])<span class="product-tag {{ str_contains($product['tag'], '%') ? 'discount' : '' }}">{{ $product['tag'] }}</span>@endif
                    <button class="favorite-button {{ in_array($product['id'], $favorites, true) ? 'active' : '' }}" type="button" wire:click="toggleFavorite({{ $product['id'] }})" aria-label="Додати в обране">
                        <svg viewBox="0 0 24 24"><path d="M20 8.8c0 5-8 10-8 10s-8-5-8-10A4.3 4.3 0 0 1 12 6.5a4.3 4.3 0 0 1 8 2.3Z"/></svg>
                    </button>
                    <div class="product-art {{ $product['type'] }}" aria-hidden="true"><i></i><i></i><i></i><b></b></div>
                </div>
                <h3>{{ $product['name'] }}</h3>
                <strong class="price">{{ $product['price'] }} грн</strong>
                <button class="cart-button" type="button" wire:click="addToCart({{ $product['id'] }})" wire:loading.attr="disabled" wire:target="addToCart({{ $product['id'] }})">
                    <svg viewBox="0 0 24 24"><path d="M3 4h2l1.5 10h11l2-7H6"/><circle cx="9" cy="19" r="1"/><circle cx="17" cy="19" r="1"/></svg>
                    <span>{{ isset($cart[$product['id']]) ? 'Ще один · '.$cart[$product['id']] : 'У кошик' }}</span>
                </button>
            </article>
        @empty
            <div class="empty-state">
                <span>⌕</span><strong>Нічого не знайшли</strong><small>Спробуйте інший запит або категорію</small>
            </div>
        @endforelse
    </div>
</section>
