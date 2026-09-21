@component('emails.layouts.message', ['title' => 'Confirm your '.$type.' change'])
<p>Someone requested a change to your Hapsay {{ $type }}. The change will not be made unless you confirm it.</p><p style="margin:28px 0"><a href="{{ $url }}" style="background:#1d4ed8;color:#fff;padding:12px 18px;border-radius:7px;text-decoration:none;font-weight:bold">Confirm {{ $type }} change</a></p><p>This single-use link expires in 30 minutes. If this was not you, ignore this message.</p>
@endcomponent
