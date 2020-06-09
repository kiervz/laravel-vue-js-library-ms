<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookCategory extends Model
{
    protected $guarded = [];

    public function book()
    {
        return $this->hasOne(Book::class);
    }
}
