@component('mail::message')
# تفعيل الحساب

مرحباً،

هذا هو كود التحقق الخاص بك:

@component('mail::panel')
{{ $code }}
@endcomponent

إذا لم تطلب هذا الكود، فيمكنك تجاهل هذه الرسالة.

شكراً لك،
{{ config('app.name') }}
@endcomponent
