<?php

namespace App\Models;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Member extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, CanResetPassword;

    protected $table = 'members';

    /**
     * Kolom yang bisa diisi secara massal
     */
    protected $fillable = [
        'name',
        'member_id',
        'email',
        'phone',
        'address',
        'password',
        'is_active',
        'is_login',
        'avatar',
        'otp_code',
        'otp_expires_at',
    ];

    /**
     * Kolom yang harus disembunyikan
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting tipe data
     */
    protected $casts = [
        'is_active' => 'boolean',
        'is_login' => 'boolean',
        'otp_expires_at' => 'datetime',
    ];

    /**
     * Aksesor untuk URL foto
     */
    public function getPhotoUrlAttribute()
    {
        return $this->avatar
            ? asset('storage/members/' . $this->avatar)
            : asset('storage/members/avatar.jpg'); // fallback ke avatar default
    }

    public function getOtpCodeAttribute($value)
    {
        return $value;
    }
}



