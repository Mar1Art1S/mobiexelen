<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#f8bd16">
    <title>Beehive — усе для бджільництва</title>
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="store-page">
    <div class="store-shell" x-data="storefrontUi()" @store-toast.window="showToast($event.detail.message)">
        <livewire:storefront.header />
        <main>
            <x-storefront.category-strip />
            <x-storefront.hero-banner />
            <x-storefront.service-cards />
            <x-storefront.benefits />
            <livewire:storefront.catalog />
            <x-storefront.promo-strip />
        </main>
        <livewire:storefront.contact-form />
        <x-storefront.bottom-nav />
        <div class="store-toast" role="status" aria-live="polite" x-show="toast" x-transition x-text="toast" x-cloak></div>
    </div>
    @livewireScripts
</body>
</html>
