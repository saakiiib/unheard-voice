<footer>
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="brand">
                    @if($company->footer_logo)
                        <img src="{{ asset('uploads/company/' . $company->footer_logo) }}" alt="{{ $company->company_name ?? 'Footer Logo' }}">
                    @elseif($company->company_logo)
                        <img src="{{ asset('uploads/company/' . $company->company_logo) }}" alt="{{ $company->company_name ?? 'Logo' }}">
                    @endif
                </div>
                
                <p class="mt-3" style="max-width:340px">
                    {{ $company->footer_content ?? 'Empowering ethnically diverse communities in Milton Keynes with stigma-free, culturally sensitive mental health support.' }}
                </p>
                
                @if($company->facebook || $company->instagram || $company->linkedin || $company->youtube)
                    <div class="socials mt-3">
                        @if($company->facebook)
                            <a href="{{ $company->facebook }}" target="_blank" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                        @endif
                        @if($company->instagram)
                            <a href="{{ $company->instagram }}" target="_blank" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                        @endif
                        @if($company->linkedin)
                            <a href="{{ $company->linkedin }}" target="_blank" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
                        @endif
                        @if($company->youtube)
                            <a href="{{ $company->youtube }}" target="_blank" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                        @endif
                    </div>
                @endif
            </div>

            <div class="col-6 col-lg-2">
                <h5>Explore</h5>
                <a @spa href="{{ route('home') }}">Home</a><br>
                <a @spa href="{{ route('about') }}">About</a><br>
                <a @spa href="{{ route('team') }}">Our Team</a><br>
                <a @spa href="{{ route('activities') }}">Activities</a>
            </div>

            <div class="col-6 col-lg-2">
                <h5>More</h5>
                <a @spa href="{{ route('blogs') }}">Blogs</a><br>  
                <a @spa href="{{ route('events') }}">Events</a><br>
                <a @spa href="{{ route('contact') }}">Contact</a><br>
                <a @spa href="{{ route('donate') }}">Donate</a><br>
            </div>

            <div class="col-lg-4">
                <h5>Contact</h5>
                @if($company->address1)
                    <p class="mb-1">
                        <i class="bi bi-geo-alt me-2"></i>
                        {{ $company->address1 }}{{ $company->address2 ? ', ' . $company->address2 : '' }}{{ $company->address3 ? ', ' . $company->address3 : '' }}
                    </p>
                @endif
                
                @if($company->email1)
                    <p class="mb-1">
                        <i class="bi bi-envelope me-2"></i>
                        <a href="mailto:{{ $company->email1 }}">{{ $company->email1 }}</a>
                    </p>
                @endif
                
                @if($company->phone1)
                    <p class="mb-0">
                        <i class="bi bi-telephone me-2"></i>
                        <a href="tel:{{ str_replace(' ', '', $company->phone1) }}">{{ $company->phone1 }}</a>
                    </p>
                @endif
                @if($company->phone2)
                    <p class="mb-0">
                        <i class="bi bi-telephone me-2"></i>
                        <a href="tel:{{ str_replace(' ', '', $company->phone2) }}">{{ $company->phone2 }}</a>
                    </p>
                @endif
            </div>
        </div>

       <div class="bottom d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
            <span>
                © {{ date('Y') }} {{ $company->company_name ?? 'Unheard Voices MK' }}. 
                @if($company->company_reg_number)
                    &nbsp;Registered Charity No. {{ $company->company_reg_number }}
                @endif
            </span>
            <span>Developed by <a href="https://mentosoftware.co.uk/" target="_blank" rel="noopener noreferrer" aria-label="Mento Software">Mento Software</a></span>
            <span>
                <a @spa href="{{ route('privacy') }}">Privacy</a> · 
                <a @spa href="{{ route('terms') }}">Terms & Conditions</a> · 
                <a @spa href="{{ route('faq') }}">FAQs</a>
            </span>
        </div>
    </div>
</footer>