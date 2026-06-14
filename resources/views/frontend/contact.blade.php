@extends('frontend.master')

@section('title', 'যোগাযোগ')

@section('content')

<section class="pb-cat-hero">
    <div class="container-pb">
        <h1 class="my-1">যোগাযোগ</h1>
        <div class="sub">যেকোনো জিজ্ঞাসা, মতামত বা বিজ্ঞাপনের জন্য আমাদের কাছে লিখুন</div>
    </div>
</section>

<section class="pb-section py-5">
    <div class="container-pb">
        <div class="row g-4 justify-content-center">
            
            <div class="col-lg-8">
                <div class="pb-contact-box">
                    
                    <div id="form-message" class="pb-alert-success d-none"></div>
                    <div id="form-error-message" class="pb-alert-danger d-none"></div>

                    <form id="contact-form" action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="pb-form-label">আপনার নাম *</label>
                                <input type="text" name="name" class="pb-form-input" required>
                                <span class="pb-form-error d-none" id="error-name"></span>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="pb-form-label">ইমেইল ঠিকানা *</label>
                                <input type="email" name="email" class="pb-form-input" required>
                                <span class="pb-form-error d-none" id="error-email"></span>
                            </div>

                            <div class="col-md-6">
                                <label class="pb-form-label">মোবাইল নম্বর</label>
                                <input type="text" name="phone" class="pb-form-input">
                                <span class="pb-form-error d-none" id="error-phone"></span>
                            </div>

                            <div class="col-md-6">
                                <label class="pb-form-label">বিষয়</label>
                                <input type="text" name="subject" class="pb-form-input">
                                <span class="pb-form-error d-none" id="error-subject"></span>
                            </div>

                            <div class="col-12">
                                <label class="pb-form-label">বার্তা *</label>
                                <textarea name="message" class="pb-form-textarea" rows="5" required></textarea>
                                <span class="pb-form-error d-none" id="error-message"></span>
                            </div>

                            <div class="col-12">
                                <div class="d-flex align-items-center gap-2">
                                    <label class="pb-form-label mb-0" id="captcha-question"></label>
                                    <input type="number" id="captcha-answer" class="pb-form-input" style="width:120px;" placeholder="উত্তর দিন" required>
                                </div>
                                <span id="captcha-error" class="pb-form-error d-none">ভুল উত্তর, আবার চেষ্টা করুন।</span>
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="pb-btn-submit" id="btn-submit">
                                    <i class="bi bi-send-fill me-1"></i> বার্তা পাঠান
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

@section('script')
<script>
    $(document).ready(function () {
        let num1 = Math.floor(Math.random() * 10) + 1;
        let num2 = Math.floor(Math.random() * 10) + 1;
        let correctAnswer = num1 + num2;

        $('#captcha-question').text(`${num1} + ${num2} = কত? *`);

        $('#contact-form').on('submit', function (e) {
            e.preventDefault();
            
            $('.pbs-form-error').addClass('d-none').text('');
            $('#form-message').addClass('d-none').text('');
            $('#form-error-message').addClass('d-none').text('');

            let userAnswer = parseInt($('#captcha-answer').val());
            if (userAnswer !== correctAnswer) {
                $('#captcha-error').removeClass('d-none');
                $('#form-error-message').removeClass('d-none').html('<i class="bi bi-exclamation-circle-fill me-2"></i> সিকিউরিটি ক্যাপচা উত্তরটি ভুল হয়েছে।');
                return false;
            }

            let form = $(this);
            let actionUrl = form.attr('action');
            let formData = form.serialize();
            let submitBtn = $('#btn-submit');

            submitBtn.prop('disabled', true).text('পাঠানো হচ্ছে...');

            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        $('#form-message').removeClass('d-none').html(`<i class="bi bi-check-circle-fill me-2"></i> ${response.message}`);
                        form[0].reset();
                        
                        num1 = Math.floor(Math.random() * 10) + 1;
                        num2 = Math.floor(Math.random() * 10) + 1;
                        correctAnswer = num1 + num2;
                        $('#captcha-question').text(`${num1} + ${num2} = কত? *`);
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            $(`#error-${key}`).removeClass('d-none').text(value[0]);
                        });
                    } else {
                        $('#form-error-message').removeClass('d-none').html('<i class="bi bi-exclamation-circle-fill me-2"></i> দুঃখিত, কোথাও কোনো সমস্যা হয়েছে। আবার চেষ্টা করুন।');
                    }
                },
                complete: function () {
                    submitBtn.prop('disabled', false).html('<i class="bi bi-send-fill me-1"></i> বার্তা পাঠান');
                }
            });
        });
    });
</script>
@endsection