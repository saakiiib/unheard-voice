<section class="bg-dark-gradient">
    <div class="container">
        <div class="text-center mb-5">
            <span class="eyebrow">Support & Resources</span>
            <h2 style="color:#fff">You are not alone</h2>
            <hr class="divider mx-auto">
            <p class="lead" style="max-width:600px;margin:0 auto;color:rgba(255,255,255,.75)">If you or someone you know
                needs support right
                now, these trusted organisations are here to help.</p>
        </div>
        <div class="row g-3 justify-content-center">
            @foreach ([['icon' => 'bi-heart-pulse-fill', 'title' => 'NHS Mental Health Hub', 'url' => 'https://www.nhs.uk/mental-health/'], ['icon' => 'bi-telephone-fill', 'title' => 'Samaritans', 'url' => 'https://www.samaritans.org/'], ['icon' => 'bi-chat-dots-fill', 'title' => 'Shout Text Support', 'url' => 'https://giveusashout.org/'], ['icon' => 'bi-translate', 'title' => 'Royal College of Psychiatrists', 'url' => 'https://www.rcpsych.ac.uk/mental-health/translations'], ['icon' => 'bi-file-earmark-text-fill', 'title' => 'Translated Resources', 'url' => 'https://slam.nhs.uk/translated-resources']] as $resource)
                <div class="col-sm-6 col-lg-4">
                    <a href="{{ $resource['url'] }}" target="_blank" rel="noopener noreferrer"
                        class="text-decoration-none d-flex flex-column align-items-center text-center p-4 h-100 rounded-4"
                        style="border:1.5px solid rgba(255,255,255,.12);background:rgba(255,255,255,.07);transition:.25s;gap:.6rem"
                        onmouseover="this.style.borderColor='var(--teal)';this.style.transform='translateY(-4px)';this.style.background='rgba(255,255,255,.12)'"
                        onmouseout="this.style.borderColor='rgba(255,255,255,.12)';this.style.transform='none';this.style.background='rgba(255,255,255,.07)'">
                        <span
                            style="width:52px;height:52px;border-radius:14px;background:rgba(95,189,180,.2);color:var(--teal);display:inline-flex;align-items:center;justify-content:center;font-size:1.35rem;flex-shrink:0">
                            <i class="bi {{ $resource['icon'] }}"></i>
                        </span>
                        <div style="font-weight:700;color:#fff;font-size:.97rem;line-height:1.3">
                            {{ $resource['title'] }}</div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="cta-band">
            <div class="row align-items-center g-3 position-relative" style="z-index:2">
                <div class="col-lg-8">
                    <h2>Believe mental health should never be hidden?</h2>
                    <p class="mt-2 mb-0">Get in touch, volunteer, or partner with us — every voice strengthens the
                        movement.</p>
                </div>
                <div class="col-lg-4 text-lg-end"><a @spa href="{{ route('contact') }}" class="btn btn-teal btn-lg">Get
                        In Touch</a>
                </div>
            </div>
        </div>
    </div>
</section>