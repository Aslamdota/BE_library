<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Member extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'members';
    protected $guarded = [];
    // app/Models/Member.php
    public function getPhotoUrlAttribute()
    {
        return asset('storage/members/' . $this->avatar); // asumsi field 'photo' menyimpan nama file
    }

}



