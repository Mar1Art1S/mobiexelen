<header class="mobile-header">
    <div class="header-main">
        <button class="menu-button" type="button" aria-label="Відкрити меню" @click="showToast('Меню магазину — незабаром')">
            <span></span><span></span>
        </button>

        <a class="brand" href="#" aria-label="Хімекселен — на головну">
            <span class="brand-mark" aria-hidden="true">
                <i></i><i></i><i></i><i></i><i></i><i></i><b></b>
            </span>
            <span class="brand-copy">
                <strong>Хімекселен</strong>
                <small>Вулики з ППУ</small>
            </span>
        </a>

        <nav class="header-actions" aria-label="Швидкі дії">
            <x-header-cart :count="$cartCount" />
            <button class="icon-action profile-action" type="button" aria-label="Профіль" @click="showToast('Особистий кабінет — незабаром')">
                <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="7.5" r="3.5"/><path d="M5.5 20c.5-4 2.7-6 6.5-6s6 2 6.5 6"/></svg>
                <span>Профіль</span>
            </button>
        </nav>
    </div>

    <button class="location-row" type="button" @click="showToast('Доставка по всій Україні')">
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 21s6-5.2 6-11a6 6 0 1 0-12 0c0 5.8 6 11 6 11Z"/><circle cx="12" cy="10" r="2"/></svg>
        <span>Доставка по всій Україні</span>
        <svg class="location-chevron" viewBox="0 0 24 24" aria-hidden="true"><path d="m8 10 4 4 4-4"/></svg>
    </button>

    <x-header-search />
</header>
