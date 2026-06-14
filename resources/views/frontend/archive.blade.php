@extends('frontend.master')

@section('title', 'আর্কাইভ')

@section('content')

<section class="pb-cat-hero">
    <div class="container-pb">
        <h1 class="my-1"><i class="bi bi-calendar3 me-2"></i>পুরোনো খবর (আর্কাইভ)</h1>
        <div class="sub">নির্দিষ্ট তারিখ সিলেক্ট করে ওই দিনের সব খবরাখবর দেখে নিন</div>
    </div>
</section>

<section class="pb-section py-5">
    <div class="container-pb">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 text-center">
                
                <div class="archive-box p-4 bg-white border rounded shadow-sm mb-4">
                    <form action="{{ route('search') }}" method="GET">
                        <label class="form-label fw-bold mb-3 text-dark">তারিখ নির্বাচন করুন</label>
                        
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light"><i class="bi bi-calendar-event"></i></span>
                            <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        
                        <button type="submit" class="btn pb-btn-epaper w-100 py-2">
                            <i class="bi bi-search me-1"></i> খবর খুঁজুন
                        </button>
                    </form>
                </div>

                <p class="text-muted small">নোট: আপনি যেকোনো তারিখের আর্কাইভ সংস্করণের খবর এখান থেকে ব্রাউজ করতে পারবেন।</p>

            </div>
        </div>
    </div>
</section>

@endsection