@props(['activePage' => 'home'])

<div class="bottom-navigation" x-data="bottomNavigation(@js($activePage))" @contact-form-closed.window="active = @js($activePage)">
    <button
        class="scroll-top-button"
        :class="{ 'is-visible': showScrollTop && ! hidden }"
        :tabindex="showScrollTop && ! hidden ? 0 : -1"
        type="button"
        aria-label="Повернутися вгору"
        title="Повернутися вгору"
        @click="scrollToTop()"
        x-cloak
    >
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m6 14 6-6 6 6" /></svg>
    </button>

    <nav class="bottom-nav" aria-label="Головна навігація" :class="{ 'is-hidden': hidden }">
        <a href="{{ route('home') }}" wire:navigate :class="{ active: active === 'home' }" @click="active = 'home'">
            <span>⌂</span>Головна
        </a>
        <a href="{{ route('catalog') }}" wire:navigate :class="{ active: active === 'catalog' }" @click="active = 'catalog'">
            <span>▦</span>Каталог
        </a>
        <a href="{{ route('tips') }}" wire:navigate :class="{ active: active === 'tips' }" @click="active = 'tips'">
            <span>◇</span>Поради
        </a>
        <button :class="{ active: active === 'contacts' }" type="button" @click="active = 'contacts'; $dispatch('contact-form-opened')">
            <span>♧</span>Контакти
        </button>
        <button :class="{ active: active === 'more' }" type="button" @click="active = 'more'; showToast('Додаткове меню')">
            <span>☰</span>Більше
        </button>
    </nav>
</div>
