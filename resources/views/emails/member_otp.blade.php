<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kode OTP</title>
</head>
<body>
    <h2>Hai {{ $member->name }},</h2>
    <p>Berikut adalah kode OTP untuk aktivasi akun Anda:</p>
    <h1>{{ $member->otp_code }}</h1>
    <p>Berikan kode ini kepada admin untuk mengaktifkan akun Anda.</p>
    <p>Terima kasih.</p>
</body>
</html>
