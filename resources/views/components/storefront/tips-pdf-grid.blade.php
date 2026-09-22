@php
    $documents = [
        ['title' => 'Інструкція для 8-рамкового вулика', 'label' => '8 рамок', 'url' => 'https://bee.lg.ua/images/beelg/instruction-8ua.pdf'],
        ['title' => 'Інструкція для 10-рамкового вулика', 'label' => '10 рамок', 'url' => 'https://bee.lg.ua/images/beelg/instruction-10ua.pdf'],
        ['title' => 'Інструкція для 12-рамкового вулика', 'label' => '12 рамок', 'url' => 'https://bee.lg.ua/images/beelg/instruction-12ua.pdf'],
    ];
@endphp

<section class="tips-module" aria-labelledby="pdf-guides-title">
    <div class="tips-section-heading">
        <span class="tips-heading-icon tips-heading-icon-pdf" aria-hidden="true">PDF</span>
        <span>
            <strong id="pdf-guides-title">Інструкції для складання</strong>
            <small>Офіційні матеріали українською мовою</small>
        </span>
    </div>

    <div class="tips-document-list">
        @foreach ($documents as $document)
            <a class="tips-document-card" href="{{ $document['url'] }}" target="_blank" rel="noopener noreferrer">
                <span class="tips-document-icon" aria-hidden="true"><i>PDF</i></span>
                <span>
                    <small>{{ $document['label'] }}</small>
                    <strong>{{ $document['title'] }}</strong>
                    <em>Відкрити інструкцію <b>↗</b></em>
                </span>
            </a>
        @endforeach
    </div>

    <aside class="tips-assembly-card">
        <span class="tips-assembly-visual" aria-hidden="true"><i></i><i></i><i></i></span>
        <span>
            <small>Практична база</small>
            <strong>Збірка елементів вулика</strong>
            <p>Детальні відеоінструкції зі складання окремих комплектуючих частин для вуликів ППУ.</p>
        </span>
    </aside>
</section>
