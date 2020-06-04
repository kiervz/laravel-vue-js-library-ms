<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	"isbn",	"call_number", "title",	"author", "publisher",	"description", "category_id", "date_published",	"series", "avail_copies", "total_copies", "price"
    ];

    public function category()
    {
        return $this->belongsTo(BookCategory::class);
    }
}
