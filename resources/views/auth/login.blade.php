@extends('frontend.master')

@section('title', 'Sign In')

@section('content')

    <header class="page-hero" style="--page-img:url('{{ asset('resources/frontend/img/banner.webp') }}')">
        <div class="container">
            <nav class="crumbs" aria-label="Breadcrumb">
                <a @spa href="{{ route('home') }}">Home</a><span class="sep">/</span><span>Sign In</span>
            </nav>
            <span class="eyebrow light">Welcome back</span>
            <h1>Sign in</h1>
            <p class="lead mt-3">Login to your account to access your portal.</p>
        </div>
    </header>

    <section>
        <div class="container">
            <div class="row g-5 justify-content-center">

                <div class="col-lg-6">
                    <div class="form-card">
                        <span class="eyebrow">Account access</span>
                        <h3 class="mb-3" style="font-family:'Fraunces',serif">Sign in to continue</h3>

                        <form method="POST" action="{{ route('login') }}" class="mt-2">
                            @csrf

                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Email address <span class="text-danger">*</span></label>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus
                                        placeholder="your@email.com" />

                                    @error('email')
                                        <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Password <span class="text-danger">*</span></label>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password" placeholder="Enter your password" />

                                    @error('password')
                                        <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 mt-2">
                                    <button type="submit" class="btn btn-teal btn-lg w-100">
                                        Sign In <i class="bi bi-box-arrow-in-right ms-1"></i>
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