@component('emails.layouts.message', ['title' => 'Verify your email address'])
<p>Welcome to Hapsay. Please verify your email address to help protect your account.</p><p style="margin:28px 0"><a href="{{ $url }}" style="background:#1d4ed8;color:#fff;padding:12px 18px;border-radius:7px;text-decoration:none;font-weight:bold">Verify email address</a></p><p>This link expires in 60 minutes.</p>
@endcomponent
