<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    protected $guarded = [];

    protected $dates = ['borrow_date', 'due_date', 'return_date'];

    // Relasi ke buku
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // Relasi ke anggota
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    // Relasi ke petugas/staff (User)
    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
}
