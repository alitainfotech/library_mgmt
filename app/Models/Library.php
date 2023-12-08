<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Library extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'libraries';

    public function books()
    {
        return $this->hasMany(Book::class,'library','id');
    }
}
