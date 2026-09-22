@php
    $frames = [
        ['size' => '145', 'title' => 'Рамка 145', 'description' => 'Креслення для магазину або надставки 145 мм.'],
        ['size' => '230', 'title' => 'Рамка 230', 'description' => 'Креслення корпусу під рамку 230 мм.'],
        ['size' => '300', 'title' => 'Рамка 300', 'description' => 'Креслення корпусу під рамку 300 мм.'],
    ];
@endphp

<section class="tips-module" aria-labelledby="drawings-title">
    <div class="tips-section-heading">
        <span class="tips-heading-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24"><path d="M4 20 20 4M8 4h12v12M5 14l5 5M9 10l5 5"/></svg>
        </span>
        <span>
            <strong id="drawings-title">Розміри рамок</strong>
            <small>Основні формати та призначення</small>
        </span>
    </div>

    <div class="tips-frame-grid">
        @foreach ($frames as $frame)
            <article class="tips-frame-card">
                <span class="tips-frame-visual" aria-hidden="true"><i></i><b>{{ $frame['size'] }}</b></span>
                <strong>{{ $frame['title'] }}</strong>
                <p>{{ $frame['description'] }}</p>
            </article>
        @endforeach
    </div>

    <div class="tips-section-heading tips-config-heading">
        <span class="tips-heading-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24"><path d="M5 7h14v12H5zM8 4h8v3M9 11h6M9 15h6"/></svg>
        </span>
        <span>
            <strong>Варіанти наборів</strong>
            <small>Готові комплектації вуликів</small>
        </span>
    </div>

    <div class="tips-config-grid">
        <article><span>8</span><strong>Комплектація 8 рамок</strong><small>Компактний варіант для мобільної пасіки</small></article>
        <article><span>10/12</span><strong>Комплектація 10/12 рамок</strong><small>Більше простору для розвитку сім’ї</small></article>
    </div>
</section>
