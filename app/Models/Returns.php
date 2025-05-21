<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Returns extends Model
{
    protected $guarded = [];

    public function loans(){
        return $this->belongsTo(Loan::class);
    }
}
