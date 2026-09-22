@php
    $topics = [
        ['label' => '8 рамок', 'mark' => '8', 'theme' => 'yellow'],
        ['label' => '10 рамок', 'mark' => '10', 'theme' => 'green'],
        ['label' => '12 рамок', 'mark' => '12', 'theme' => 'blue'],
        ['label' => 'Збірка', 'mark' => '⌁', 'theme' => 'orange'],
        ['label' => 'Вентиляція', 'mark' => '↟', 'theme' => 'mint'],
        ['label' => 'Мікронуклеус', 'mark' => 'М', 'theme' => 'violet'],
    ];
@endphp

<section class="tips-stories" aria-labelledby="tips-stories-title">
    <div class="tips-section-heading tips-story-heading">
        <span class="tips-heading-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="m10 8 6 4-6 4Z"/></svg>
        </span>
        <span>
            <strong id="tips-stories-title">Дивіться та навчайтесь</strong>
            <small>Короткі поради про вулики та їх складання</small>
        </span>
        <b>14 відео</b>
    </div>

    <div class="tips-story-track">
        @foreach ($topics as $topic)
            <button type="button" class="tips-story" @click="tab = 'videos'; $nextTick(() => document.getElementById('video-reviews')?.scrollIntoView({ behavior: 'smooth', block: 'start' }))">
                <span class="tips-story-ring tips-story-{{ $topic['theme'] }}"><i>{{ $topic['mark'] }}</i></span>
                <small>{{ $topic['label'] }}</small>
            </button>
        @endforeach
    </div>
</section>
