<article class="product-card">
    <div class="product-visual">
        @if ($product['tag'])
            <span class="product-tag {{ str_contains($product['tag'], '%') ? 'discount' : '' }}">{{ $product['tag'] }}</span>
        @endif
        <button class="favorite-button {{ $favorite ? 'active' : '' }}" type="button" wire:click="toggleFavorite" aria-label="Додати в обране">
            <svg viewBox="0 0 24 24"><path d="M20 8.8c0 5-8 10-8 10s-8-5-8-10A4.3 4.3 0 0 1 12 6.5a4.3 4.3 0 0 1 8 2.3Z"/></svg>
        </button>
        <div class="product-art {{ $product['type'] }}" aria-hidden="true" wire:ignore><i></i><i></i><i></i><b></b></div>
    </div>

    <h3 wire:ignore>{{ $product['name'] }}</h3>

    <div class="product-purchase">
        <strong class="price" aria-label="Сума: {{ number_format($displayPrice, 0, '', ' ') }} гривень">
            {{ number_format($displayPrice, 0, '', ' ') }} грн
        </strong>

        @if ($quantity > 0)
            <div class="quantity-control">
                <button
                    type="button"
                    aria-label="Зменшити кількість {{ $product['name'] }}"
                    wire:click="decrementCart"
                    wire:loading.attr="disabled"
                    wire:target="decrementCart"
                >−</button>
                <strong aria-label="Кількість: {{ $quantity }}">{{ $quantity }}</strong>
                <button
                    type="button"
                    aria-label="Збільшити кількість {{ $product['name'] }}"
                    wire:click="addToCart"
                    wire:loading.attr="disabled"
                    wire:target="addToCart"
                >+</button>
            </div>
        @else
            <button class="cart-button" type="button" wire:click="addToCart" wire:loading.attr="disabled" wire:target="addToCart">
                <svg viewBox="0 0 24 24"><path d="M3 4h2l1.5 10h11l2-7H6"/><circle cx="9" cy="19" r="1"/><circle cx="17" cy="19" r="1"/></svg>
                <span>У кошик</span>
            </button>
        @endif
    </div>
</article>
