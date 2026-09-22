@php $benefits = [['▰', 'Швидка доставка', 'по Україні'], ['♢', 'Гарантія', 'якості ППУ'], ['♧', 'Консультація', 'бджоляра'], ['♙', 'Вироблено', 'в Україні 🇺🇦']]; @endphp
<section class="benefits" aria-label="Наші переваги">
    @foreach ($benefits as [$icon, $title, $subtitle])
        <article><b aria-hidden="true">{{ $icon }}</b><strong>{{ $title }}</strong><small>{{ $subtitle }}</small></article>
    @endforeach
</section>
