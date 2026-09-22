<section class="tips-content" x-data="{ tab: 'videos' }">
    <header class="tips-hero">
        <span class="tips-kicker">База знань пасічника</span>
        <h1>Відеоматеріали та інструкції</h1>
        <p>Корисна добірка оглядів вуликів з ППУ, відеоінструкцій для складання, креслень рамок та варіантів комплектацій.</p>
    </header>

    <x-storefront.tips-story-row />

    <nav class="tips-tabs" aria-label="Розділи порад">
        <button type="button" :class="{ 'is-active': tab === 'videos' }" @click="tab = 'videos'">Відео огляди</button>
        <button type="button" :class="{ 'is-active': tab === 'pdf' }" @click="tab = 'pdf'">PDF Інструкції &amp; Збірка</button>
        <button type="button" :class="{ 'is-active': tab === 'drawings' }" @click="tab = 'drawings'">Розміри та Креслення</button>
    </nav>

    <div x-show="tab === 'videos'" x-transition.opacity>
        <x-storefront.tips-video-grid />
    </div>

    <div x-show="tab === 'pdf'" x-transition.opacity x-cloak>
        <x-storefront.tips-pdf-grid />
    </div>

    <div x-show="tab === 'drawings'" x-transition.opacity x-cloak>
        <x-storefront.tips-drawings-grid />
    </div>
</section>
