@component('mail::message')
# Halo, {{ $user->name ?? 'Pengguna' }} 👋

Kami menerima permintaan untuk mengatur ulang password akun Anda.

@component('mail::button', ['url' => $actionUrl])
Reset Password
@endcomponent

Jika Anda tidak meminta reset password, abaikan saja email ini.

Terima kasih telah menggunakan layanan kami!  
{{ config('app.name') }} ✨

@endcomponent
