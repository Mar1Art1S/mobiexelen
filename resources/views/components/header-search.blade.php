@props([
    'model' => 'search',
    'label' => 'Пошук',
    'placeholder' => 'Що шукаєте?',
])

<form class="header-search" role="search" @submit.prevent>
    <span class="search-icon" aria-hidden="true">
        <svg viewBox="0 0 24 24" aria-hidden="true">
            <circle cx="11" cy="11" r="6.5" />
            <path d="m16 16 4 4" />
        </svg>
    </span>

    <input
        type="search"
        placeholder="{{ $placeholder }}"
        aria-label="{{ $label }} товарів"
        wire:model.live.debounce.250ms="{{ $model }}"
    >

    <button class="search-filter" type="button" aria-label="Очистити пошук" @click="$wire.set(@js($model), '')">
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 7h10M18 7h2M4 17h2M10 17h10"/><circle cx="16" cy="7" r="2"/><circle cx="8" cy="17" r="2"/></svg>
    </button>
</form>
