@extends('frontend.master')
@section('title', 'Contact Us')

@section('content')

    <header class="page-hero" style="--page-img:url('{{ asset('resources/frontend/img/banner.webp') }}')">
        <div class="container">
            <nav class="crumbs" aria-label="Breadcrumb">
                <a @spa href="{{ route('home') }}">Home</a><span class="sep">/</span><span>Contact</span>
            </nav>
            <span class="eyebrow light">Contact Us</span>
            <h1>Let&rsquo;s talk</h1>
            <p class="lead mt-3">We&rsquo;d love to hear from you. Our team usually replies within one working day.</p>
        </div>
    </header>

    <section>
        <div class="container">
            <div class="row g-5 align-items-start">

                <div class="col-lg-5">
                    <span class="eyebrow">Have a question?</span>
                    <h2>Get in touch</h2>
                    <hr class="divider">
                    <p class="muted mb-4">Whether you want to volunteer, partner with us, or simply ask a question —
                        we&rsquo;re here to listen.</p>

                    <div class="contact-hero-card mb-3">
                        <h3>We're here to listen</h3>
                        <p>You don&rsquo;t need the right words to reach out. Just a moment of courage.</p>
                    </div>

                    <div class="d-flex flex-column gap-3">

                        @if ($companyDetails->address1)
                            <div class="contact-card">
                                <div class="ico"><i class="bi bi-geo-alt-fill"></i></div>
                                <div>
                                    <h4>Visit us</h4>
                                    <p>
                                        {{ $companyDetails->address1 }}
                                        @if ($companyDetails->address2)
                                            <br>{{ $companyDetails->address2 }}
                                        @endif
                                        @if ($companyDetails->address3)
                                            <br>{{ $companyDetails->address3 }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endif

                        @if ($companyDetails->email1)
                            <div class="contact-card">
                                <div class="ico"><i class="bi bi-envelope-fill"></i></div>
                                <div>
                                    <h4>Email us</h4>
                                    <a href="mailto:{{ $companyDetails->email1 }}">{{ $companyDetails->email1 }}</a>
                                    @if ($companyDetails->email2)
                                        <a href="mailto:{{ $companyDetails->email2 }}"
                                            class="d-block mt-1">{{ $companyDetails->email2 }}</a>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if ($companyDetails->phone1)
                            <div class="contact-card">
                                <div class="ico"><i class="bi bi-telephone-fill"></i></div>
                                <div>
                                    <h4>Call us</h4>
                                    <a href="tel:{{ $companyDetails->phone1 }}">{{ $companyDetails->phone1 }}</a>
                                    @if ($companyDetails->phone2)
                                        <a href="tel:{{ $companyDetails->phone2 }}"
                                            class="d-block mt-1">{{ $companyDetails->phone2 }}</a>
                                    @endif
                                    @if ($companyDetails->opening_time)
                                        <p class="mt-1" style="font-size:.85rem">{{ $companyDetails->opening_time }}</p>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if ($companyDetails->whatsapp)
                            <div class="contact-card">
                                <div class="ico"><i class="bi bi-whatsapp"></i></div>
                                <div>
                                    <h4>WhatsApp</h4>
                                    <a href="https://wa.me/{{ $companyDetails->whatsapp }}"
                                        target="_blank">{{ $companyDetails->whatsapp }}</a>
                                </div>
                            </div>
                        @endif

                        @if ($companyDetails->facebook || $companyDetails->instagram || $companyDetails->linkedin || $companyDetails->twitter)
                            <div class="contact-card">
                                <div class="ico"><i class="bi bi-chat-heart-fill"></i></div>
                                <div>
                                    <h4>Follow us</h4>
                                    <p>Stay close to our community on social.</p>
                                    <div class="mt-2 d-flex gap-2">
                                        @if ($companyDetails->facebook)
                                            <a href="{{ $companyDetails->facebook }}" target="_blank"
                                                class="btn btn-outline-teal btn-sm" style="padding:.4rem .8rem"><i
                                                    class="bi bi-facebook"></i></a>
                                        @endif
                                        @if ($companyDetails->instagram)
                                            <a href="{{ $companyDetails->instagram }}" target="_blank"
                                                class="btn btn-outline-teal btn-sm" style="padding:.4rem .8rem"><i
                                                    class="bi bi-instagram"></i></a>
                                        @endif
                                        @if ($companyDetails->linkedin)
                                            <a href="{{ $companyDetails->linkedin }}" target="_blank"
                                                class="btn btn-outline-teal btn-sm" style="padding:.4rem .8rem"><i
                                                    class="bi bi-linkedin"></i></a>
                                        @endif
                                        @if ($companyDetails->twitter)
                                            <a href="{{ $companyDetails->twitter }}" target="_blank"
                                                class="btn btn-outline-teal btn-sm" style="padding:.4rem .8rem"><i
                                                    class="bi bi-twitter-x"></i></a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="form-card">
                        <span class="eyebrow">Send a message</span>
                        <h3 class="mb-3" style="font-family:'Fraunces',serif">We read every message.</h3>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="contact_name" placeholder="Your full name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="contact_email" placeholder="your@email.com">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <input type="text" class="form-control" id="contact_phone"
                                    placeholder="Your phone number">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Reason for enquiry <span class="text-danger">*</span></label>
                                <select id="contact_subject">
                                    <option value="">Choose&hellip;</option>
                                    <option value="Volunteer with us">Volunteer with us</option>
                                    <option value="Partner with us">Partner with us</option>
                                    <option value="General enquiry">General enquiry</option>
                                    <option value="Support">Support</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Your message <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="contact_message" rows="5" placeholder="Write your message here..."></textarea>
                            </div>

                            {{-- Captcha --}}
                            <div class="col-12">
                                <label class="form-label" id="captcha_question"></label>
                                <input type="number" class="form-control" id="captcha_answer" placeholder="Your answer"
                                    style="max-width:160px;">
                                <div class="text-danger mt-1 d-none" id="captcha_error">Incorrect answer, please try
                                    again.</div>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-teal btn-lg" id="contactSubmitBtn">
                                    Send Message <i class="bi bi-arrow-right"></i>
                                </button>
                            </div>
                            <div class="col-12">
                                <div class="alert alert-success d-none" id="contactSuccess">
                                    <i class="bi bi-check-circle me-2"></i>Thanks &mdash; your message is on its way.
                                </div>
                                <div class="alert alert-danger d-none" id="contactError"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    @if ($companyDetails->google_map)
        <section class="bg-cream">
            <div class="container">
                <div class="text-center mb-4">
                    <span class="eyebrow">Find us</span>
                    <h2>Come say hello</h2>
                </div>
                <div class="map-wrap">
                    <iframe title="Map" src="{{ $companyDetails->google_map }}" height="460"
                        loading="lazy"></iframe>
                </div>
            </div>
        </section>
    @endif

    @include('frontend.cta')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css">

@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    <script>
        $(document).ready(function() {

            new TomSelect('#contact_subject', {
                allowEmptyOption: true,
            });

            var num1 = Math.floor(Math.random() * 10) + 1;
            var num2 = Math.floor(Math.random() * 10) + 1;
            var correctAnswer = num1 + num2;
            $('#captcha_question').text('What is ' + num1 + ' + ' + num2 + '? *');

            $('#contactSubmitBtn').on('click', function() {

                $('#contactSuccess').addClass('d-none');
                $('#contactError').addClass('d-none');
                $('#captcha_error').addClass('d-none');

                var userAnswer = parseInt($('#captcha_answer').val());
                if (isNaN(userAnswer) || userAnswer !== correctAnswer) {
                    $('#captcha_error').removeClass('d-none');
                    return;
                }

                var name = $('#contact_name').val().trim();
                var email = $('#contact_email').val().trim();
                var phone = $('#contact_phone').val().trim();
                var subject = $('#contact_subject').val();
                var message = $('#contact_message').val().trim();

                if (!name || !email || !message || !subject) {
                    $('#contactError').removeClass('d-none').text('Please fill in all required fields.');
                    return;
                }

                console.log('name:', name, 'email:', email, 'subject:', subject, 'message:', message);

                $.ajax({
                    url: '{{ route('contact.store') }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        name,
                        email,
                        phone,
                        subject,
                        message
                    },
                    success: function(res) {
                        if (res.success) {
                            $('#contactSuccess').removeClass('d-none');
                            $('#contact_name, #contact_email, #contact_phone, #contact_message')
                                .val('');
                            $('#captcha_answer').val('');
                            document.getElementById('contact_subject').tomselect.clear();
                            num1 = Math.floor(Math.random() * 10) + 1;
                            num2 = Math.floor(Math.random() * 10) + 1;
                            correctAnswer = num1 + num2;
                            $('#captcha_question').text('What is ' + num1 + ' + ' + num2 +
                                '? *');
                        }
                    },
                    error: function(xhr) {
                        var msg = 'Something went wrong. Please try again.';
                        if (xhr.status === 422) {
                            msg = Object.values(xhr.responseJSON.errors)[0][0];
                        }
                        $('#contactError').removeClass('d-none').text(msg);
                    }
                });
            });
        });
    </script>
@endsection