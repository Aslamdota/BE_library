<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book_missing extends Model
{   
    protected $table = 'book_missings';
    protected $guarded = [];

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    // Relasi ke model Member
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
