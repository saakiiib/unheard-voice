@extends('frontend.master')
@section('title', 'Donate')

@section('content')

    <header class="page-hero" style="--page-img:url('{{ asset('resources/frontend/img/banner.webp') }}')">
        <div class="container">
            <nav class="crumbs" aria-label="Breadcrumb">
                <a @spa href="{{ route('home') }}">Home</a><span class="sep">/</span><span>Donate</span>
            </nav>
            <span class="eyebrow light">Support Us</span>
            <h1>Make a difference today.</h1>
            <p class="lead mt-3">Your generosity helps us reach more people who need culturally sensitive mental health
                support.</p>
        </div>
    </header>

    <section>
        <div class="container">
            <div class="row g-5 align-items-start">

                <div class="col-lg-7">
                    <span class="eyebrow">Choose an amount</span>
                    <h2>Pick what feels right</h2>
                    <hr class="divider">

                    <div class="row g-3 mt-1">
                        <div class="col-sm-4">
                            <div class="donate-tier" data-amount="20">
                                <div class="amt">£20</div>
                                <div class="desc">Funds one person's workshop place</div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="donate-tier active" data-amount="50">
                                <div class="amt">£50</div>
                                <div class="desc">Supports a community meetup</div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="donate-tier" data-amount="120">
                                <div class="amt">£120</div>
                                <div class="desc">Trains a new champion</div>
                            </div>
                        </div>
                    </div>

                    <div class="card-soft mt-4">
                        <h3>Where your donation goes</h3>
                        <ul class="list-unstyled muted mt-3 mb-0">
                            <li class="mb-2"><i class="bi bi-dot" style="color:var(--teal)"></i> Free, culturally
                                sensitive workshops in community spaces</li>
                            <li class="mb-2"><i class="bi bi-dot" style="color:var(--teal)"></i> Multilingual peer-support
                                volunteers</li>
                            <li class="mb-2"><i class="bi bi-dot" style="color:var(--teal)"></i> Outreach to faith
                                centres, schools and youth groups</li>
                            <li><i class="bi bi-dot" style="color:var(--teal)"></i> Translation of mental-health resources
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="form-card">
                        <h3>Make a donation</h3>
                        <p class="muted small mb-4">Secure, one-off or monthly. Gift Aid available.</p>

                        <div class="row g-2 mb-3 d-none">
                            <div class="col-6">
                                <button class="btn btn-outline-ink w-100 donate-type-btn" id="btnOneOff"
                                    type="button">One-off</button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-teal w-100 donate-type-btn" id="btnMonthly"
                                    type="button">Monthly</button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Amount (£)</label>
                            <input id="donation-amount" type="number" min="1" value="50" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Full name</label>
                            <input type="text" class="form-control" id="donate_name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" id="donate_email">
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="gift">
                            <label class="form-check-label small muted" for="gift">
                                Add Gift Aid — boost my donation by 25% at no extra cost.
                            </label>
                        </div>

                        <button class="btn btn-teal btn-lg w-100" id="donateBtn">
                            <i class="bi bi-heart-fill me-2"></i>Donate Now
                        </button>

                        <div class="alert alert-success mt-3 d-none" id="donateSuccess">
                            <i class="bi bi-check-circle me-2"></i>Thank you for your generosity!
                        </div>

                        <p class="text-center small muted mt-3 mb-0">
                            This is a demo form. Wire up Stripe / GoCardless for live payments.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    @include('frontend.cta')

@endsection

@section('script')
    <script>
        $(document).ready(function() {

            // Donate tier click
            $('.donate-tier').on('click', function() {
                $('.donate-tier').removeClass('active');
                $(this).addClass('active');
                $('#donation-amount').val($(this).data('amount'));
            });

            // Type toggle
            $('#btnOneOff').on('click', function() {
                $(this).removeClass('btn-outline-ink').addClass('btn-teal');
                $('#btnMonthly').removeClass('btn-teal').addClass('btn-outline-ink');
            });

            $('#btnMonthly').on('click', function() {
                $(this).removeClass('btn-outline-ink').addClass('btn-teal');
                $('#btnOneOff').removeClass('btn-teal').addClass('btn-outline-ink');
            });

            // Demo submit
            $('#donateBtn').on('click', function() {
                var name = $('#donate_name').val().trim();
                var email = $('#donate_email').val().trim();
                var amount = $('#donation-amount').val();

                if (!name || !email || !amount) {
                    return;
                }

                $('#donateSuccess').removeClass('d-none');
            });

        });
    </script>
@endsection