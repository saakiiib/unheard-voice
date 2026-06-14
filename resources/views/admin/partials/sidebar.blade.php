<div class="app-menu navbar-menu">
    <div class="navbar-brand-box">
        <a href="{{ route('home') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('uploads/company/' . $company->company_logo) }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('uploads/company/' . $company->company_logo) }}" alt="" height="40">
            </span>
        </a>
        <a href="{{ route('home') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('uploads/company/' . $company->company_logo) }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('uploads/company/' . $company->company_logo) }}" alt="" height="40">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu"></div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                        <i class="ri-dashboard-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('blog.index') }}"
                    class="nav-link {{ Route::is('blog.*') ? 'active' : '' }}">
                        <i class="ri-article-line"></i>
                        <span>Blogs</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('event.index') }}"
                    class="nav-link {{ Route::is('event.*') ? 'active' : '' }}">
                        <i class="ri-calendar-event-line"></i>
                        <span>Events</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('activity.index') }}"
                    class="nav-link {{ Route::is('activity.*') ? 'active' : '' }}">
                        <i class="ri-run-line"></i>
                        <span>Activities</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('category.index') }}"
                    class="nav-link {{ Route::is('category.*') ? 'active' : '' }}">
                        <i class="ri-list-check-2"></i>
                        <span>Categories</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('slider.index') }}"
                    class="nav-link {{ Route::is('slider.*') ? 'active' : '' }}">
                        <i class="ri-slideshow-line"></i>
                        <span>Hero Sliders</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('program.index') }}"
                    class="nav-link {{ Route::is('program.*') ? 'active' : '' }}">
                        <i class="ri-book-open-line"></i>
                        <span>Programs</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('testimonial.index') }}"
                    class="nav-link {{ Route::is('testimonial.*') ? 'active' : '' }}">
                        <i class="ri-discuss-line"></i>
                        <span>Testimonials</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ Route::is('contacts.*') ? 'active' : '' }}"
                        href="{{ route('contacts.index') }}">
                        <i class="ri-contacts-book-line"></i>
                        <span>Contacts</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.companyDetails') }}"
                        class="nav-link {{ Route::is('admin.companyDetails') ? 'active' : '' }}">
                        <i class="ri-settings-3-line"></i>
                        <span>Company Details</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('page-seo.index') }}" @spa
                        class="nav-link {{ Route::is('page-seo.index') ? 'active' : '' }}">
                        <i class="ri-search-eye-line"></i>
                        <span>Other SEO</span>
                    </a>
                </li>

                <li class="nav-item" style="margin-bottom: 200px"></li>
            </ul>
        </div>
    </div>
</div>
