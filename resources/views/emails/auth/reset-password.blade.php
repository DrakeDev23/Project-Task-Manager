@component('emails.layouts.message', ['title' => 'Reset your password'])
<p>We received a request to reset your Hapsay password. This does not reveal or include your password.</p><p style="margin:28px 0"><a href="{{ $url }}" style="background:#1d4ed8;color:#fff;padding:12px 18px;border-radius:7px;text-decoration:none;font-weight:bold">Reset password</a></p><p>This link expires in {{ $expires }} minutes. If you did not request it, no action is needed.</p>
@endcomponent
