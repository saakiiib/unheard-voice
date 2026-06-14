@extends('frontend.master')

@section('title', 'সাইন ইন')

@section('content')

    <section class="pb-cat-hero">
        <div class="container-pb">
            <h1 class="my-1">সাইন ইন</h1>
            <div class="sub">আপনার অ্যাকাউন্ট লগইন করে আমাদের পোর্টালে প্রবেশ করুন</div>
        </div>
    </section>

    <section class="pb-section py-5">
        <div class="container-pb">
            <div class="row g-4 justify-content-center">

                <div class="col-lg-6 col-md-8">
                    <div class="pb-contact-box">
                        <form method="POST" action="{{ route('login') }}" class="mt-2">
                            @csrf

                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="pb-form-label">ইমেইল ঠিকানা *</label>
                                    <input id="email" type="email"
                                        class="pb-form-input @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus
                                        placeholder="আপনার ইমেইল দিন" />

                                    @error('email')
                                        <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="pb-form-label">পাসওয়ার্ড *</label>
                                    <input id="password" type="password"
                                        class="pb-form-input @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password" placeholder="আপনার পাসওয়ার্ড দিন" />

                                    @error('password')
                                        <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 mt-4">
                                    <button type="submit" class="pb-btn-submit w-100 justify-content-center">
                                        <i class="bi bi-box-arrow-in-right me-1"></i> সাইন ইন করুন
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection