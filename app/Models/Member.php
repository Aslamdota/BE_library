<?php

namespace App\Models;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Member extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, CanResetPassword;

    protected $table = 'members';
    protected $guarded = [];
    // app/Models/Member.php
    public function getPhotoUrlAttribute()
    {
        return asset('storage/members/' . $this->avatar); // asumsi field 'photo' menyimpan nama file
    }

}



