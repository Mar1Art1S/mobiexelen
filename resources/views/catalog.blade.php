<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#ffffff">
    <title>Каталог — Хімекселен</title>
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="store-page">
    <div class="store-shell catalog-page" x-data="storefrontUi()" @store-toast.window="showToast($event.detail.message)">
        <livewire:storefront.header />

        <main class="catalog-page-main">
            <x-storefront.catalog-category-grid />
        </main>

        <livewire:storefront.cart-modal />
        <livewire:storefront.contact-form />
        <x-storefront.bottom-nav active-page="catalog" />
        <div class="store-toast" role="status" aria-live="polite" x-show="toast" x-transition x-text="toast" x-cloak></div>
    </div>
    @livewireScripts
</body>
</html>
