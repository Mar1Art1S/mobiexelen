<section class="hero" aria-label="Акційні пропозиції" x-data="heroSlider()" :class="`slide-${slide}`">
    <div class="hero-copy">
        <p class="hero-kicker" x-text="slides[slide].kicker"></p>
        <h1><span x-text="slides[slide].title"></span><br><em x-text="slides[slide].subtitle"></em></h1>
        <div class="hero-points"><span>🌡 Теплі взимку</span><span>🪶 Легкі та зручні</span><span>♢ Служать роками</span></div>
        <button class="primary-button" type="button" @click="document.querySelector('#catalog').scrollIntoView({ behavior: 'smooth' })">Переглянути каталог <b>→</b></button>
    </div>
    <div class="hero-art" aria-hidden="true">
        <div class="sun"></div><div class="hive-stack"><i></i><i></i><i></i></div>
        <div class="bee bee-one">●</div><div class="bee bee-two">●</div>
    </div>
    <div class="hero-note">Більше меду<br><strong>менше клопоту!</strong></div>
    <div class="hero-dots" aria-label="Слайди">
        <template x-for="(_, index) in slides" :key="index">
            <button type="button" @click="slide = index" :class="{ active: slide === index }" :aria-label="`Слайд ${index + 1}`"></button>
        </template>
    </div>
</section>
