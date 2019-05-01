<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    //
    protected $fillable = ['name', 'isbn', 'price'];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
