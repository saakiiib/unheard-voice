@extends('frontend.master')

@section('title', 'লাইভ')

@section('content')

<section class="pb-cat-hero">
    <div class="container-pb">
        <h1 class="my-1"><span class="pulse d-inline-block me-2" style="background: red;"></span>লাইভ আপডেট</h1>
        <div class="sub">চলমান ঘটনার সর্বশেষ খবরাখবর এবং লাইভ সম্প্রচার</div>
    </div>
</section>

<section class="pb-section py-5">
    <div class="container-pb">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8 text-center">
                
                <div class="live-stream-wrapper p-3 bg-white border rounded shadow-sm mb-4" style="aspect-ratio: 16/9; background: #000 !important;">
                    <img src="{{ asset('placeholder.webp') }}" alt="লাইভ সম্প্রচার" class="img-fluid w-100 h-100 rounded" style="object-fit: cover;">
                </div>

                <p class="text-muted small"><i class="bi bi-clock-history"></i> লাইভ সম্প্রচারটি স্বয়ংক্রিয়ভাবে আপডেট হচ্ছে...</p>

            </div>
        </div>
    </div>
</section>

@endsection