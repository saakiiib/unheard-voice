@extends('frontend.master')

@section('title', 'ই-পেপার')

@section('content')

<section class="pb-cat-hero">
    <div class="container-pb">
        <h1 class="my-1">আজকের ই-পেপার</h1>
        <div class="sub">ডিজিটাল সংস্করণে আজকের পুরো পত্রিকা পড়ুন</div>
    </div>
</section>

<section class="pb-section py-5">
    <div class="container-pb">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8 text-center">
                
                <div class="epaper-wrapper p-3 bg-white border rounded shadow-sm mb-4">
                    <img src="{{ asset('placeholder.webp') }}" alt="আজকের ই-পেপার" class="img-fluid w-100 rounded">
                </div>

                <div class="d-flex justify-content-between align-items-center px-2">
                    <button class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i> আগের পাতা</button>
                    <span class="text-muted small">পাতা: ১ / ১২</span>
                    <button class="btn btn-outline-secondary btn-sm">পরের পাতা <i class="bi bi-arrow-right ms-1"></i></button>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection