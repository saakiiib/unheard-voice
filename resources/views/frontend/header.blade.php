<div class="topbar">
    <div class="container">
        <div class="tb-left">
            @if ($company->address1)
                <span>
                    <i class="bi bi-geo-alt-fill"></i>
                    {{ $company->address1 }}{{ $company->address2 ? ', ' . $company->address2 : '' }}{{ $company->address3 ? ', ' . $company->address3 : '' }}
                </span>
            @endif

            @if ($company->opening_time)
                <span class="hide-sm"><i class="bi bi-clock-fill"></i>{{ $company->opening_time }}</span>
            @endif
        </div>
        <div class="tb-right">
            @if ($company->phone1)
                <a href="tel:{{ str_replace(' ', '', $company->phone1) }}"><i
                        class="bi bi-telephone-fill"></i>{{ $company->phone1 }}</a>
            @endif

            @if ($company->email1)
                <a href="mailto:{{ $company->email1 }}"><i class="bi bi-envelope-fill"></i>{{ $company->email1 }}</a>
            @endif

            @if ($company->facebook || $company->instagram || $company->linkedin)
                <span class="socials">Follow:
                    @if ($company->facebook)
                        <a href="{{ $company->facebook }}" target="_blank" aria-label="Facebook"><i
                                class="bi bi-facebook"></i></a>
                    @endif
                    @if ($company->instagram)
                        <a href="{{ $company->instagram }}" target="_blank" aria-label="Instagram"><i
                                class="bi bi-instagram"></i></a>
                    @endif
                    @if ($company->linkedin)
                        <a href="{{ $company->linkedin }}" target="_blank" aria-label="LinkedIn"><i
                                class="bi bi-linkedin"></i></a>
                    @endif
                </span>
            @endif
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a @spa class="navbar-brand" href="{{ route('home') }}">
            @if ($company->company_logo)
                <img src="{{ asset('uploads/company/' . $company->company_logo) }}"
                    alt="{{ $company->company_name ?? 'Logo' }}">
            @else
                <span class="fw-bold">{{ $company->company_name ?? 'Unheard Voices MK' }}</span>
            @endif
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
            aria-label="Menu">
            <i class="bi bi-list fs-3"></i>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a @spa class="nav-link {{ Route::is('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a @spa class="nav-link {{ Route::is('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a>
                </li>
                <li class="nav-item">
                    <a @spa class="nav-link {{ Route::is('team') ? 'active' : '' }}" href="{{ route('team') }}">Our
                        Team</a>
                </li>
                <li class="nav-item">
                    <a @spa class="nav-link {{ Route::is('activities*') ? 'active' : '' }}"
                        href="{{ route('activities') }}">Activities</a>
                </li>
                <li class="nav-item">
                    <a @spa class="nav-link {{ Route::is('blogs*') ? 'active' : '' }}"
                        href="{{ route('blogs') }}">Blogs</a>
                </li>
                <li class="nav-item">
                    <a @spa class="nav-link {{ Route::is('events*') ? 'active' : '' }}"
                        href="{{ route('events') }}">Events</a>
                </li>
                <li class="nav-item">
                    <a @spa class="nav-link {{ Route::is('contact') ? 'active' : '' }}"
                        href="{{ route('contact') }}">Contact</a>
                </li>
            </ul>
            <a @spa class="btn btn-teal btn-donate ms-lg-3" href="{{ route('donate') }}"><i class="bi bi-heart-fill"></i>
                Donate</a>
        </div>
    </div>
</nav>