<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $appends = ['authors'];

    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }

    public function getAuthorsAttribute()
    {
        $authorIds = explode(',', $this->attributes['author_id']);
        return Author::whereIn('id', $authorIds)->get();
    }

    public function libraryName()
    {
        return $this->belongsTo(Library::class,'library');
    }


}
