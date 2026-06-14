@extends('frontend.master')

@section('title', 'ক্যারিয়ার')

@section('content')

<section class="pb-cat-hero">
    <div class="container-pb">
        <h1 class="my-1">ক্যারিয়ার</h1>
        <div class="sub">বস্তুনিষ্ঠ সাংবাদিকতা ও দক্ষ টিম মেম্বার হিসেবে আপনার ক্যারিয়ার গড়ুন</div>
    </div>
</section>

<section class="pb-section py-5">
    <div class="container-pb">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                
                <div class="pb-contact-box text-dark" style="line-height: 1.8;">
                    <h3 class="mb-3">আমাদের সাথে কাজ করুন</h3>
                    <p class="mb-4">আমরা সবসময় তরুণ, মেধাবী এবং কঠোর পরিশ্রমি কর্মীদের খুঁজছি যারা সংবাদের সততা বজায় রেখে কাজ করতে আগ্রহী। এখানে আপনি একটি পেশাদার এবং বন্ধুত্বপূর্ণ কাজের পরিবেশ পাবেন।</p>
                    
                    <div class="pb-alert-success m-0">
                        <i class="bi bi-info-circle-fill me-2"></i> আমাদের সাথে কাজ করতে আগ্রহী হলে অনুগ্রহ করে আমাদের <a @spa href="{{ route('contact') }}" class="text-decoration-underline fw-bold" style="color: inherit;">যোগাযোগ পেজ</a> থেকে আপনার নাম, মোবাইল নম্বর এবং সংক্ষিপ্ত বার্তা লিখে আমাদের সাথে যোগাযোগ করুন। আপনার তথ্য পাওয়ার পর আমরা সরাসরি আপনার সাথে ফোনে যোগাযোগ (Call) করব।
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection