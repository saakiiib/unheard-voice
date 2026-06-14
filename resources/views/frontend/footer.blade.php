@php
    $half = (int) ceil($categories->count() / 2);
    $firstHalf = $categories->take($half);
    $secondHalf = $categories->skip($half);
@endphp

<footer class="pb-footer">
    <div class="pb-foot-top">
        <div class="container-pb">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="pb-foot-logo mb-2">
                        <a @spa href="{{ route('home') }}" aria-label="{{ $company->company_name ?? '' }} — হোম">
                        @if ($company->footer_logo)
                            <img src="{{ asset('uploads/company/' . $company->footer_logo) }}"
                                alt="{{ $company->company_name ?? '' }}" style="max-height:55px; width:auto;">
                        @elseif($company->company_logo)
                            <img src="{{ asset('uploads/company/' . $company->company_logo) }}"
                                alt="{{ $company->company_name ?? '' }}" style="max-height:55px; width:auto;">
                        @else
                        @endif
                        </a>
                    </div>
                    @if ($company->footer_content)
                        <p style="font-size:13.5px; max-width:340px;">{{ $company->footer_content }}</p>
                    @else
                        <p style="font-size:13.5px; max-width:340px;">সত্যের পক্ষে, সময়ের সঙ্গে। দেশ ও বিশ্বের সর্বশেষ
                            সংবাদ পেতে আমাদের সঙ্গে থাকুন।</p>
                    @endif
                    <div class="d-flex gap-2 mt-3">
                        <a href="{{ $company->facebook ?: '#' }}"
                            {{ $company->facebook ? 'target=_blank rel=noopener' : '' }} class="d-inline-grid"
                            style="width:34px;height:34px;background:#1b2228;border-radius:6px;place-items:center;">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="{{ $company->twitter ?: '#' }}"
                            {{ $company->twitter ? 'target=_blank rel=noopener' : '' }} class="d-inline-grid"
                            style="width:34px;height:34px;background:#1b2228;border-radius:6px;place-items:center;">
                            <i class="bi bi-twitter-x"></i>
                        </a>
                        <a href="{{ $company->youtube ?: '#' }}"
                            {{ $company->youtube ? 'target=_blank rel=noopener' : '' }} class="d-inline-grid"
                            style="width:34px;height:34px;background:#1b2228;border-radius:6px;place-items:center;">
                            <i class="bi bi-youtube"></i>
                        </a>
                        <a href="{{ $company->instagram ?: '#' }}"
                            {{ $company->instagram ? 'target=_blank rel=noopener' : '' }} class="d-inline-grid"
                            style="width:34px;height:34px;background:#1b2228;border-radius:6px;place-items:center;">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="{{ $company->linkedin ?: '#' }}"
                            {{ $company->linkedin ? 'target=_blank rel=noopener' : '' }} class="d-inline-grid"
                            style="width:34px;height:34px;background:#1b2228;border-radius:6px;place-items:center;">
                            <i class="bi bi-linkedin"></i>
                        </a>
                    </div>
                </div>

                <div class="col-6 col-md-3 col-lg-2">
                    <h4>বিভাগ</h4>
                    <ul>
                        @foreach ($firstHalf as $cat)
                            <li><a @spa href="{{ route('category.show', $cat->slug) }}">{{ $cat->name }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div class="col-6 col-md-3 col-lg-2">
                    <h4>আরও</h4>
                    <ul>
                        @foreach ($secondHalf as $cat)
                            <li><a @spa href="{{ route('category.show', $cat->slug) }}">{{ $cat->name }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div class="col-6 col-md-3 col-lg-2">
                    <h4>{{ $company->company_name ?? '' }}</h4>
                    <ul>
                        <li><a @spa href="{{ route('about') }}">আমাদের কথা</a></li>
                        <li><a @spa href="{{ route('contact') }}">যোগাযোগ</a></li>
                        <li><a @spa href="{{ route('advertise') }}">বিজ্ঞাপন</a></li>
                        <li class="d-none"><a @spa href="{{ route('career') }}">ক্যারিয়ার</a></li>
                        <li><a @spa href="{{ route('privacy') }}">গোপনীয়তা নীতি</a></li>
                    </ul>
                </div>

                <div class="col-6 col-md-3 col-lg-2">
                    <h4>যোগাযোগ</h4>
                    <ul>
                        @if ($company->address1)
                            <li><i class="bi bi-geo-alt"></i> {{ $company->address1 }}</li>
                        @endif
                        @if ($company->address2)
                            <li><i class="bi bi-geo-alt-fill"></i> {{ $company->address2 }}</li>
                        @endif
                        @if ($company->phone1)
                            <li><i class="bi bi-telephone"></i> {{ $company->phone1 }}</li>
                        @endif
                        @if ($company->phone2)
                            <li><i class="bi bi-telephone-fill"></i> {{ $company->phone2 }}</li>
                        @endif
                        @if ($company->email1)
                            <li><i class="bi bi-envelope"></i> {{ $company->email1 }}</li>
                        @endif
                        @if ($company->whatsapp)
                            <li><i class="bi bi-whatsapp"></i> {{ $company->whatsapp }}</li>
                        @endif
                    </ul>
                </div>

            </div>
        </div>
    </div>

    <div class="container-pb pb-foot-bottom">
        <span>
            © {{ now()->year }} {{ $company->company_name ?? '' }}। সর্বস্বত্ব সংরক্ষিত।
        </span>
        <span>
            Designed & Developed by <a href="http://liliumit.com" target="_blank" rel="noopener">Lilium Info Tech</a>
        </span>
        <span>
            @if ($company->business_name)
                সম্পাদক ও প্রকাশক: {{ $company->business_name }}
            @endif
        </span>
    </div>
</footer>