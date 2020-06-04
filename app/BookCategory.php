<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookCategory extends Model
{
    public function book()
    {
        return $this->hasOne(Book::class);
    }
}
