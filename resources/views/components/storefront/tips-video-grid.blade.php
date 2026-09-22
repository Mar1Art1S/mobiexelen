@php
    $videos = [
        ['title' => 'Розміри 8-рамкового вулика Дадан', 'url' => 'https://www.youtube.com/watch?v=KCti6YD28lI', 'time' => '8:14', 'theme' => 'amber'],
        ['title' => 'Розміри 10-рамкового вулика Дадан', 'url' => 'https://www.youtube.com/watch?v=bqXjQN2bKi8', 'time' => '9:26', 'theme' => 'forest'],
        ['title' => 'Складання 8-рамкового вулика', 'url' => 'https://www.youtube.com/watch?v=pNT9XXGoNf4', 'time' => '12:08', 'theme' => 'blue'],
        ['title' => 'Складання 10-рамкового вулика', 'url' => 'https://www.youtube.com/watch?v=oGYW3VwWTSQ', 'time' => '13:41', 'theme' => 'plum'],
        ['title' => 'Вставка для додаткової вентиляції', 'url' => 'https://www.youtube.com/watch?v=TApO1IoBCok', 'time' => '4:32', 'theme' => 'mint'],
        ['title' => 'Дно з літковою перегородкою', 'url' => 'https://www.youtube.com/watch?v=e4BEjlRz-CU', 'time' => '5:17', 'theme' => 'clay'],
        ['title' => 'Складання мікронуклеуса', 'url' => 'https://www.youtube.com/watch?v=4QqDPew2z0U', 'time' => '10:04', 'theme' => 'navy'],
        ['title' => 'Розміри мікронуклеуса', 'url' => 'https://www.youtube.com/watch?v=UbwPcW29kbo', 'time' => '6:48', 'theme' => 'honey'],
        ['title' => 'Фальци на вуликах з пінополіуретану', 'url' => 'https://www.youtube.com/watch?v=A2uvHpNLQIg', 'time' => '3:39', 'theme' => 'olive'],
        ['title' => 'Заміна старих вуликів на нові ППУ', 'url' => 'https://www.youtube.com/watch?v=t-RntQH6BKk', 'time' => '7:21', 'theme' => 'rust'],
        ['title' => 'Теплоізоляція та вентиляція влітку', 'url' => 'https://www.youtube.com/watch?v=wVgB5nN1_eE', 'time' => '8:55', 'theme' => 'sky'],
        ['title' => 'Переселення сім’ї у вулик із ППУ', 'url' => 'https://www.youtube.com/watch?v=FQbLXRikJs4', 'time' => '11:12', 'theme' => 'green'],
    ];
@endphp

<section class="tips-module" id="video-reviews" aria-labelledby="video-reviews-title">
    <div class="tips-section-heading">
        <span class="tips-heading-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="3"/><path d="m10 9 5 3-5 3Z"/></svg>
        </span>
        <span>
            <strong id="video-reviews-title">Відео огляди</strong>
            <small>Натисніть на картку, щоб відкрити відео</small>
        </span>
    </div>

    <div class="tips-video-grid">
        @foreach ($videos as $video)
            <a class="tips-video-card tips-video-{{ $video['theme'] }}" href="{{ $video['url'] }}" target="_blank" rel="noopener noreferrer" aria-label="Дивитися: {{ $video['title'] }}">
                <span class="tips-video-badge">
                    <svg viewBox="0 0 20 20" aria-hidden="true"><path d="m7 5 7 5-7 5Z"/></svg>
                    {{ $video['time'] }}
                </span>
                <span class="tips-video-count" aria-label="Одне відео">
                    <svg viewBox="0 0 20 20" aria-hidden="true"><rect x="3" y="4" width="11" height="10" rx="2"/><path d="M7 17h9a2 2 0 0 0 2-2V8"/></svg>1
                </span>
                <span class="tips-video-art" aria-hidden="true"><i></i><b></b><em></em></span>
                <span class="tips-card-play" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="m9 7 8 5-8 5Z"/></svg></span>
                <strong>{{ $video['title'] }}</strong>
                <small>Хімекселен</small>
            </a>
        @endforeach
    </div>
</section>
