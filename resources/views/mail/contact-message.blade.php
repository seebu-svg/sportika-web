<x-mail::message>
# New contact message

A visitor sent a message through the **{{ config('app.name') }}** website.

<x-mail::panel>
**From:** {{ $message->name }} ({{ $message->email }})@if($message->phone) — {{ $message->phone }}@endif

**Subject:** {{ $message->subject }}

{{ $message->message }}
</x-mail::panel>

Reply directly to this email to answer {{ $message->name }}, or manage the message in the admin panel.

Thanks,<br>
{{ config('app.name') }} Website
</x-mail::message>
