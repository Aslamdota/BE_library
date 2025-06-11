<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Member;

class MemberOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $member;

    public function __construct(Member $member)
    {
        $this->member = $member;
    }

    public function build()
    {
        return $this->subject('Kode OTP Aktivasi Akun')
                    ->view('emails.member_otp');
    }
}
