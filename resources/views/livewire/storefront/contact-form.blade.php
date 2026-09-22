<div
    class="contact-modal-root"
    x-data="contactModal()"
    @contact-form-opened.window="openModal()"
    @contact-submitted.window="complete($event.detail.message)"
    @keydown.escape.window="closeModal()"
>
    <div
        class="contact-backdrop"
        x-show="open"
        x-transition.opacity
        @click="closeModal()"
        x-cloak
    ></div>

    <section
        class="contact-sheet"
        role="dialog"
        aria-modal="true"
        aria-labelledby="contact-sheet-title"
        x-show="open"
        x-transition:enter="contact-sheet-enter"
        x-transition:enter-start="contact-sheet-enter-start"
        x-transition:enter-end="contact-sheet-enter-end"
        x-transition:leave="contact-sheet-leave"
        x-transition:leave-start="contact-sheet-leave-start"
        x-transition:leave-end="contact-sheet-leave-end"
        @click.stop
        x-cloak
    >
        <span class="contact-sheet-handle" aria-hidden="true"></span>

        <header class="contact-sheet-header">
            <span class="contact-title-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24"><path d="M4 5h16v11H8l-4 4V5Z"/><path d="M8 9h8M8 12h5"/></svg>
            </span>
            <span>
                <small>Зворотний зв’язок</small>
                <strong id="contact-sheet-title">Зв’яжіться з нами</strong>
            </span>
            <button type="button" aria-label="Закрити форму" @click="closeModal()">×</button>
        </header>

        <div class="contact-quick-links">
            <a href="tel:+380503403547">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 3 4 5c0 7.7 6.3 14 14 14l2-3-5-3-2 2c-2.8-1.2-4.8-3.2-6-6l2-2-2-4Z"/></svg>
                <span><small>Основний телефон</small><strong>+38 050 340 35 47</strong></span>
            </a>
            <a href="mailto:info@bee.lg.ua">
                <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m4 7 8 6 8-6"/></svg>
                <span><small>Електронна пошта</small><strong>info@bee.lg.ua</strong></span>
            </a>
        </div>

        <nav class="contact-form-tabs" aria-label="Тип звернення">
            <button wire:click="changeType('message')" class="{{ $type === 'message' ? 'is-active' : '' }}" type="button">Написати</button>
            <button wire:click="changeType('callback')" class="{{ $type === 'callback' ? 'is-active' : '' }}" type="button">Зворотний дзвінок</button>
        </nav>

        <div class="contact-form-copy">
            <strong>{{ $type === 'message' ? 'Напишіть нам запитання' : 'Замовити зворотний дзвінок' }}</strong>
            <p>
                {{ $type === 'message'
                    ? 'Маєте питання щодо вуликів з ППУ, комплектацій чи доставки? Залиште повідомлення, і ми зв’яжемося з вами.'
                    : 'Вкажіть контактні дані, і наш менеджер зателефонує вам для консультації.' }}
            </p>
        </div>

        <form class="contact-form" wire:submit="submit" novalidate>
            <label>
                <span>Ваше ім’я <b>*</b></span>
                <input x-ref="firstField" wire:model.blur="name" type="text" autocomplete="name" placeholder="Олександр">
                @error('name') <small class="contact-field-error">{{ $message }}</small> @enderror
            </label>

            <label>
                <span>Номер телефону <b>*</b></span>
                <input wire:model.blur="phone" type="tel" inputmode="tel" autocomplete="tel" placeholder="+38 050 123 45 67">
                @error('phone') <small class="contact-field-error">{{ $message }}</small> @enderror
            </label>

            @if ($type === 'message')
                <label>
                    <span>Електронна пошта <em>(опціонально)</em></span>
                    <input wire:model.blur="email" type="email" inputmode="email" autocomplete="email" placeholder="example@gmail.com">
                    @error('email') <small class="contact-field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    <span>Ваше запитання / повідомлення <b>*</b></span>
                    <textarea wire:model.blur="message" rows="4" placeholder="Напишіть, що вас цікавить"></textarea>
                    @error('message') <small class="contact-field-error">{{ $message }}</small> @enderror
                </label>
            @endif

            <label class="contact-honeypot" aria-hidden="true">
                <span>Ваш сайт</span>
                <input wire:model="website" type="text" tabindex="-1" autocomplete="off">
            </label>

            <div class="contact-form-actions">
                <button class="contact-cancel-button" type="button" @click="closeModal()">Скасувати</button>
                <button class="contact-submit-button" type="submit" wire:loading.attr="disabled" wire:target="submit">
                    <span wire:loading.remove wire:target="submit">Надіслати</span>
                    <span wire:loading wire:target="submit">Надсилаємо…</span>
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m5 12 14-7-4 14-3-5-7-2Z"/></svg>
                </button>
            </div>
        </form>

        <footer class="contact-sheet-footer">
            <span>м. Кременчук, вул. Профспілкова, 11</span>
            <span>Пн–Пт 9:00–18:00 · Сб 9:00–14:00</span>
        </footer>
    </section>
</div>
