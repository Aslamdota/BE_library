<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function category() {

        return $this->belongsTo(Category::class);
    }

    public function borrowings(){
        return $this->hasMany(Borrowing::class, 'book_id', 'id');
    }

    public function loans()
    {
        return $this->hasMany(Loan::class, 'book_id');
    }

}
