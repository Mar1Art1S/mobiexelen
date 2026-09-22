<div
    class="cart-modal-root"
    x-data="{ open: $wire.entangle('open') }"
    x-effect="document.body.style.overflow = open ? 'hidden' : ''"
    @cart-open-requested.window="$wire.openCart()"
    @keydown.escape.window="if (open) $wire.closeCart()"
>
    <div
        class="cart-modal-backdrop"
        x-show="open"
        x-transition.opacity
        wire:click="closeCart"
        x-cloak
    ></div>

    <section
        class="cart-modal-sheet"
        role="dialog"
        aria-modal="true"
        aria-labelledby="cart-modal-title"
        x-show="open"
        x-transition:enter="cart-sheet-enter"
        x-transition:enter-start="cart-sheet-enter-start"
        x-transition:enter-end="cart-sheet-enter-end"
        x-transition:leave="cart-sheet-leave"
        x-transition:leave-start="cart-sheet-leave-start"
        x-transition:leave-end="cart-sheet-leave-end"
        x-cloak
    >
        <span class="cart-modal-handle" aria-hidden="true"></span>

        <header class="cart-modal-header">
            <span class="cart-modal-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24"><path d="M3 4h2l1.5 10h11l2-7H6"/><circle cx="9" cy="19" r="1"/><circle cx="17" cy="19" r="1"/></svg>
            </span>
            <span>
                <small>{{ $step === 'checkout' ? 'Контактні дані' : ($step === 'success' ? 'Замовлення прийнято' : 'Ваше замовлення') }}</small>
                <strong id="cart-modal-title">{{ $step === 'checkout' ? 'Оформлення' : ($step === 'success' ? 'Готово' : 'Кошик') }}</strong>
            </span>
            @if ($count > 0 && $step !== 'success')<b>{{ $count }}</b>@endif
            <button type="button" aria-label="Закрити кошик" wire:click="closeCart">×</button>
        </header>

        @if ($step === 'checkout' && $items !== [])
            <div class="cart-checkout">
                <button class="cart-checkout-back" type="button" wire:click="backToCart">← Повернутися до кошика</button>

                <div class="cart-checkout-total" aria-label="Підсумок замовлення">
                    <span><strong>{{ $count }} {{ trans_choice('товар|товари|товарів', $count) }}</strong><small>Сума замовлення</small></span>
                    <b>{{ number_format($total, 0, '', ' ') }} грн</b>
                </div>

                <form class="cart-checkout-form" wire:submit="submitOrder" novalidate>
                    <label>
                        <span>Ваше ім’я <b>*</b></span>
                        <input wire:model.blur="customerName" type="text" autocomplete="name" placeholder="Олександр">
                        @error('customerName') <small class="cart-checkout-error">{{ $message }}</small> @enderror
                    </label>

                    <label>
                        <span>Номер телефону <b>*</b></span>
                        <input wire:model.blur="customerPhone" type="tel" inputmode="tel" autocomplete="tel" placeholder="+38 050 123 45 67">
                        @error('customerPhone') <small class="cart-checkout-error">{{ $message }}</small> @enderror
                    </label>

                    <label>
                        <span>Електронна пошта <em>(необов’язково)</em></span>
                        <input wire:model.blur="customerEmail" type="email" inputmode="email" autocomplete="email" placeholder="example@gmail.com">
                        @error('customerEmail') <small class="cart-checkout-error">{{ $message }}</small> @enderror
                    </label>

                    <label>
                        <span>Спосіб доставки <b>*</b></span>
                        <select wire:model.blur="deliveryMethod">
                            <option value="Нова пошта">Нова пошта</option>
                            <option value="Укрпошта">Укрпошта</option>
                            <option value="Самовивіз">Самовивіз</option>
                        </select>
                        @error('deliveryMethod') <small class="cart-checkout-error">{{ $message }}</small> @enderror
                    </label>

                    <label>
                        <span>Місто або населений пункт <b>*</b></span>
                        <input wire:model.blur="city" type="text" autocomplete="address-level2" placeholder="Кременчук">
                        @error('city') <small class="cart-checkout-error">{{ $message }}</small> @enderror
                    </label>

                    <label>
                        <span>Відділення або адреса <b>*</b></span>
                        <input wire:model.blur="deliveryAddress" type="text" autocomplete="street-address" placeholder="Відділення №5 або адреса">
                        @error('deliveryAddress') <small class="cart-checkout-error">{{ $message }}</small> @enderror
                    </label>

                    <label>
                        <span>Коментар <em>(необов’язково)</em></span>
                        <textarea wire:model.blur="comment" rows="3" placeholder="Додаткова інформація до замовлення"></textarea>
                        @error('comment') <small class="cart-checkout-error">{{ $message }}</small> @enderror
                    </label>

                    <label class="cart-checkout-honeypot" aria-hidden="true">
                        <span>Ваш сайт</span>
                        <input wire:model="website" type="text" tabindex="-1" autocomplete="off">
                    </label>

                    @error('order') <p class="cart-checkout-submit-error" role="alert">{{ $message }}</p> @enderror

                    <button class="cart-checkout-submit" type="submit" wire:loading.attr="disabled" wire:target="submitOrder">
                        <span wire:loading.remove wire:target="submitOrder">Надіслати замовлення</span>
                        <span wire:loading wire:target="submitOrder">Надсилаємо…</span>
                        <span aria-hidden="true">→</span>
                    </button>
                </form>
            </div>
        @elseif ($step === 'success')
            <div class="cart-order-success">
                <span aria-hidden="true">✓</span>
                <strong>Замовлення успішно надіслано</strong>
                <p>Дякуємо! Менеджер перевірить замовлення та зв’яжеться з вами для підтвердження.</p>
                <button type="button" wire:click="closeCart">Закрити</button>
            </div>
        @elseif ($items !== [])
            <div class="cart-modal-list">
                @foreach ($items as $item)
                    <article class="cart-modal-item" wire:key="cart-item-{{ $item['id'] }}">
                        <span class="cart-item-visual" aria-hidden="true">
                            <span class="product-art {{ $item['type'] }}"><i></i><i></i><i></i><b></b></span>
                        </span>
                        <span class="cart-item-copy">
                            <strong>{{ $item['name'] }}</strong>
                            <small>{{ number_format((int) str_replace(' ', '', $item['price']), 0, '', ' ') }} грн за одиницю</small>
                            <span class="cart-item-quantity" aria-label="Кількість товару {{ $item['name'] }}">
                                <button
                                    type="button"
                                    wire:click="decrement({{ $item['id'] }})"
                                    wire:loading.attr="disabled"
                                    wire:target="decrement({{ $item['id'] }}), increment({{ $item['id'] }})"
                                    aria-label="Зменшити кількість {{ $item['name'] }}"
                                >−</button>
                                <strong aria-label="Кількість: {{ $item['quantity'] }}">{{ $item['quantity'] }}</strong>
                                <button
                                    type="button"
                                    wire:click="increment({{ $item['id'] }})"
                                    wire:loading.attr="disabled"
                                    wire:target="decrement({{ $item['id'] }}), increment({{ $item['id'] }})"
                                    aria-label="Збільшити кількість {{ $item['name'] }}"
                                >+</button>
                            </span>
                        </span>
                        <strong class="cart-item-total">{{ number_format($item['subtotal'], 0, '', ' ') }} грн</strong>
                    </article>
                @endforeach
            </div>

            <footer class="cart-modal-summary">
                <div>
                    <span>Разом</span>
                    <small>{{ $count }} {{ trans_choice('товар|товари|товарів', $count) }}</small>
                </div>
                <strong>{{ number_format($total, 0, '', ' ') }} грн</strong>
                <button type="button" wire:click="beginCheckout">
                    Оформити замовлення
                    <span>→</span>
                </button>
            </footer>
        @else
            <div class="cart-modal-empty">
                <span aria-hidden="true">🛒</span>
                <strong>Кошик поки порожній</strong>
                <p>Додайте товари з каталогу — вони з’являться тут.</p>
                <a href="{{ route('catalog') }}" wire:navigate wire:click="closeCart">Перейти до каталогу</a>
            </div>
        @endif
    </section>
</div>
