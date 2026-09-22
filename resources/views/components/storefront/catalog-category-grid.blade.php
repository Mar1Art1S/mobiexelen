@php
    $categories = [
        ['all', 'Усі товари', null, '▦'],
        ['hives', 'Готові вулики', 'hive-blue', null],
        ['bodies', 'Корпуси', 'box-yellow', null],
        ['bottoms', 'Дно', 'bottom-gray', null],
        ['roofs', 'Кришки', 'lid-gray', null],
        ['frames', 'Рамки', 'frame-wood', null],
        ['tools', 'Інструменти', 'tools-set', null],
        ['tools', 'Одяг пасічника', null, '🥼'],
        ['tools', 'Медогонки', null, '🪣'],
        ['tools', 'Вощина', null, '🟨'],
        ['tools', 'Годівниці', null, '🥣'],
        ['tools', 'Комплектуючі', null, '⚙️'],
    ];
@endphp

<section class="catalog-category-grid" aria-label="Каталог категорій">
    @foreach ($categories as [$key, $label, $type, $symbol])
        <a
            class="catalog-category-card"
            href="{{ route('shop.category', ['category' => $key]) }}"
            wire:navigate
        >
            <span class="catalog-category-visual" aria-hidden="true">
                @if ($type)
                    <span class="product-art {{ $type }}"><i></i><i></i><i></i><b></b></span>
                @else
                    <span class="catalog-category-symbol">{{ $symbol }}</span>
                @endif
            </span>
            <strong>{{ $label }}</strong>
        </a>
    @endforeach
</section>
