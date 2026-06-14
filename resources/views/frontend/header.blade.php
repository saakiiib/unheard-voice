<div class="pb-topbar">
    <div class="container-pb pb-topbar-inner">
        <div class="pb-date"><span class="dot"></span><span data-bn-date></span></div>
        <div class="pb-utilities">
            <a @spa href="{{ route('advertise') }}" class="hide-sm"><i class="bi bi-envelope"></i> বিজ্ঞাপন</a>
            <span class="sep hide-sm"></span>
            <a @spa href="{{ route('contact') }}" class="hide-sm">যোগাযোগ</a>
            <span class="sep hide-sm"></span>
            <a @spa href="{{ route('archive') }}">আর্কাইভ</a>
            <span class="sep"></span>
            <div class="pb-socials">
                @if ($company->facebook)
                    <a href="{{ $company->facebook }}" target="_blank" rel="noopener" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                @else
                    <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                @endif
                @if ($company->twitter)
                    <a href="{{ $company->twitter }}" target="_blank" rel="noopener" aria-label="X"><i class="bi bi-twitter-x"></i></a>
                @else
                    <a href="#" aria-label="X"><i class="bi bi-twitter-x"></i></a>
                @endif
                @if ($company->youtube)
                    <a href="{{ $company->youtube }}" target="_blank" rel="noopener" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                @else
                    <a href="#" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                @endif
                @if ($company->instagram)
                    <a href="{{ $company->instagram }}" target="_blank" rel="noopener" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                @else
                    <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                @endif
                @if ($company->linkedin)
                    <a href="{{ $company->linkedin }}" target="_blank" rel="noopener" aria-label="X"><i class="bi bi-linkedin"></i></a>
                @else
                    <a href="#" aria-label="X"><i class="bi bi-linkedin"></i></a>
                @endif
            </div>
        </div>
    </div>
</div>

<header class="pb-masthead">
    <div class="container-pb pb-masthead-inner">
        <a @spa class="pb-logo" href="{{ route('home') }}" aria-label="{{ $company->company_name ?? '' }} — হোম">
            @if ($company->company_logo)
                <img height="60" src="{{ asset('uploads/company/' . $company->company_logo) }}"
                    alt="{{ $company->company_name ?? '' }}">
            @else
                
            @endif
        </a>
        <div class="pb-leader-ad-wrap">
        </div>
        <div class="pb-masthead-right">
            <form class="pb-search-box" role="search" action="{{ route('search') }}">
                <input type="search" name="q" placeholder="খবর খুঁজুন…" aria-label="Search"
                    value="{{ request('q') }}" />
                <button type="submit" aria-label="Search"><i class="bi bi-search"></i></button>
            </form>
            <a @spa class="pb-btn-epaper d-none" href="{{ route('epaper') }}"><i class="bi bi-newspaper"></i> ই-পেপার</a>
        </div>
    </div>
</header>

<nav class="pb-nav">
    <div class="container-pb pb-nav-inner">
        <button class="pb-burger" data-bs-toggle="offcanvas" data-bs-target="#pbMobileMenu" aria-label="মেনু">
            <i class="bi bi-list fs-4"></i>
        </button>
        <ul class="pb-nav-list">
            <li><a @spa href="{{ route('home') }}" {{ request()->routeIs('home') ? 'class=active' : '' }}>সর্বশেষ</a></li>
            @foreach ($categories as $cat)
                <li>
                    <a @spa href="{{ route('category.show', $cat->slug) }}"
                        {{ request()->is('category/' . $cat->slug . '*') ? 'class=active' : '' }}>
                        {{ $cat->name }}
                    </a>
                </li>
            @endforeach
            <li>
                <a @spa href="{{ route('video') }}" {{ request()->routeIs('video') ? 'class=active' : '' }}>
                    ভিডিও
                </a>
            </li>
        </ul>
        <a @spa href="{{ route('live') }}" class="pb-live"><span class="pulse"></span> লাইভ</a>
    </div>
</nav>

<div class="offcanvas offcanvas-start" tabindex="-1" id="pbMobileMenu">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" style="font-family:var(--pb-font-bn);">মেনু</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body pb-offcanvas-body">
        <ul class="pb-mob-list">
            <li><a @spa href="{{ route('home') }}">সর্বশেষ</a></li>
            @foreach ($categories as $cat)
                <li><a @spa href="{{ route('category.show', $cat->slug) }}">{{ $cat->name }}</a></li>
            @endforeach
            <li><a @spa href="{{ route('video') }}">ভিডিও</a></li>
        </ul>
    </div>
</div>