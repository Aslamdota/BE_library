<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    // Relasi ke petugas/staff (User)
    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function getBookTitleAttribute()
    {
        return $this->book ? $this->book->title : null;
    }

}
