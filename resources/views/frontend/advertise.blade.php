@extends('frontend.master')

@section('title', 'বিজ্ঞাপন')

@section('content')

<section class="pb-cat-hero">
    <div class="container-pb">
        <h1 class="my-1">বিজ্ঞাপন</h1>
        <div class="sub">আমাদের সাথে আপনার ব্যবসার প্রচার ও প্রসারের সুযোগসমূহ</div>
    </div>
</section>

<section class="pb-section py-5">
    <div class="container-pb">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                
                <div class="pb-contact-box text-dark" style="line-height: 1.8;">
                    <h3 class="mb-3">কেন আমাদের এখানে বিজ্ঞাপন দেবেন?</h3>
                    <p class="mb-4">আমরা অত্যন্ত দ্রুততার সাথে পাঠকদের কাছে বস্তুনিষ্ঠ সংবাদ পৌঁছে দিই। আমাদের বিশাল পাঠক গোষ্ঠীর কাছে আপনার পণ্য বা সেবার বার্তা পৌঁছে দিতে আমাদের অনলাইন পোর্টালে বিজ্ঞাপন দিতে পারেন।</p>
                    
                    <h4 class="mb-3">বিজ্ঞাপনের ধরনসমূহ:</h4>
                    <ul class="ps-3 mb-4">
                        <li>হেডার ব্যানার (Leaderboard Ad)</li>
                        <li>সাইডবার স্কয়ার ব্যানার (Sidebar Square Ad)</li>
                        <li>ইন-আর্টিকেল ব্যানার (In-article Ad)</li>
                        <li>স্পন্সরড পোস্ট বা সংবাদ</li>
                    </ul>

                    <div class="pb-alert-success m-0">
                        <i class="bi bi-envelope-fill me-2"></i> বিজ্ঞাপনের মূল্য তালিকা (Rate Card) এবং বুকিংয়ের জন্য <a @spa href="{{ route('contact') }}" class="text-decoration-underline fw-bold" style="color: inherit;">যোগাযোগ</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection