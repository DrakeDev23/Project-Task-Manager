@component('emails.layouts.message', ['title' => $event])
<p>This is a security notice for your Hapsay account.</p><table role="presentation" cellspacing="0" cellpadding="0" style="font-size:14px">@foreach ($details as $label => $value)<tr><td style="padding:5px 18px 5px 0;color:#64748b">{{ $label }}</td><td style="padding:5px 0">{{ $value }}</td></tr>@endforeach</table>
@endcomponent
