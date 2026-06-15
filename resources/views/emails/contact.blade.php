<!doctype html>
<html lang="en" style="margin:0;padding:0;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ $subjectText }}</title>
    <style>
        body { margin:0; padding:0; font-family: Arial, Helvetica, sans-serif; background:#FAF8F4; }
        a { text-decoration:none; }
        @media (max-width:600px) { .container { width:100% !important; } .p-main { padding:24px 16px !important; } }
    </style>
</head>
<body style="background:#FAF8F4; margin:0; padding:0;">

<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#FAF8F4;">
    <tr>
        <td align="center" style="padding:32px 16px;">
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" class="container" style="max-width:600px;">

                {{-- Header --}}
                <tr>
                    <td style="background:linear-gradient(135deg,#1F3E55 0%,#0F2530 100%);border-radius:16px 16px 0 0;padding:32px 36px;" class="p-main">
                        <p style="margin:0;font-size:0.72rem;font-weight:700;letter-spacing:0.22em;text-transform:uppercase;color:#5FBDB4;">New Message</p>
                        <h1 style="margin:10px 0 0;font-size:1.5rem;font-weight:600;color:#ffffff;line-height:1.2;">{{ $subjectText }}</h1>
                    </td>
                </tr>

                {{-- Body --}}
                <tr>
                    <td style="background:#ffffff;padding:36px;" class="p-main">

                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin-bottom:28px;">
                            <tr>
                                <td style="padding:12px 0;border-bottom:1px solid rgba(31,62,85,0.1);">
                                    <span style="font-size:0.75rem;font-weight:700;letter-spacing:0.15em;text-transform:uppercase;color:#5F6F7A;">Name</span><br>
                                    <span style="font-size:1rem;color:#1F3E55;font-weight:600;margin-top:4px;display:block;">{{ $name }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:12px 0;border-bottom:1px solid rgba(31,62,85,0.1);">
                                    <span style="font-size:0.75rem;font-weight:700;letter-spacing:0.15em;text-transform:uppercase;color:#5F6F7A;">Email</span><br>
                                    <a href="mailto:{{ $email }}" style="font-size:1rem;color:#2E7C77;font-weight:600;margin-top:4px;display:block;">{{ $email }}</a>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:12px 0;border-bottom:1px solid rgba(31,62,85,0.1);">
                                    <span style="font-size:0.75rem;font-weight:700;letter-spacing:0.15em;text-transform:uppercase;color:#5F6F7A;">Phone</span><br>
                                    <span style="font-size:1rem;color:#1F3E55;margin-top:4px;display:block;">{{ $phone }}</span>
                                </td>
                            </tr>
                        </table>

                        <p style="margin:0 0 10px;font-size:0.75rem;font-weight:700;letter-spacing:0.15em;text-transform:uppercase;color:#5F6F7A;">Message</p>
                        <div style="background:#FAF8F4;border:1px solid rgba(31,62,85,0.1);border-left:4px solid #5FBDB4;border-radius:0 12px 12px 0;padding:20px 22px;">
                            <p style="margin:0;font-size:0.97rem;color:#243B4F;line-height:1.7;white-space:pre-wrap;">{!! nl2br(e($contactMessage)) !!}</p>
                        </div>

                    </td>
                </tr>

                {{-- Footer --}}
                <tr>
                    <td style="background:#F1ECE2;border-radius:0 0 16px 16px;padding:22px 36px;text-align:center;">
                        <p style="margin:0;font-size:0.8rem;color:#5F6F7A;">&copy; {{ date('Y') }} All rights reserved.</p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>