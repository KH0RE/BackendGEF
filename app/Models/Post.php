<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public $fillable = [
        'title',
        'photo',
        'description',
        'address',
        'latitud',
        'longitud',
        'users_id'
    ];



    public function users () {
        return $this->belongTo('App\User', 'users_id', 'id');
    }


}
