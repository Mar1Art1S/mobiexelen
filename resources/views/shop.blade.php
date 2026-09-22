@php
    $category = request()->route('category');
    $categoryTitles = [
        'all' => 'Усі товари',
        'hives' => 'Готові вулики',
        'bodies' => 'Корпуси',
        'bottoms' => 'Дно',
        'roofs' => 'Кришки',
        'frames' => 'Рамки',
        'tools' => 'Інструменти та аксесуари',
    ];
@endphp

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#ffffff">
    <title>{{ $categoryTitles[$category] }} — Хімекселен</title>
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="store-page">
    <div class="store-shell shop-page" x-data="storefrontUi()" @store-toast.window="showToast($event.detail.message)">
        <livewire:storefront.header />

        <main class="shop-page-main">
            <x-storefront.shop-category-nav :active="$category" />
            <livewire:storefront.catalog :catalog-page="true" :initial-category="$category" />
        </main>

        <livewire:storefront.cart-modal />
        <livewire:storefront.contact-form />
        <x-storefront.bottom-nav active-page="catalog" />
        <div class="store-toast" role="status" aria-live="polite" x-show="toast" x-transition x-text="toast" x-cloak></div>
    </div>
    @livewireScripts
</body>
</html>
