@props([
    'count' => 0,
    'label' => 'Кошик',
])

@php
    $count = max(0, (int) $count);
@endphp

<button
    {{ $attributes->class(['icon-action', 'has-badge']) }}
    type="button"
    aria-label="{{ $label }}, товарів: {{ $count }}"
    @click="$dispatch('cart-open-requested'); $dispatch('store-toast', { message: 'У кошику: {{ $count }} товарів' })"
>
    <svg viewBox="0 0 24 24" aria-hidden="true">
        <path d="M3 4h2l1.6 10.2h10.8l2-7.2H6" />
        <circle cx="9" cy="19" r="1.2" />
        <circle cx="17" cy="19" r="1.2" />
    </svg>

    @if ($count > 0)
        <em wire:transition>{{ $count }}</em>
    @endif

    <span>{{ $label }}</span>
</button>
