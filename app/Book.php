<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $guarded = ['number_copies'];

    public function category()
    {
        return $this->belongsTo(BookCategory::class);
    }
}
