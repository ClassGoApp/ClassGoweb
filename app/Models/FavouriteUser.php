<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavouriteUser extends Model
{
    use HasFactory;
    public $guarded = [];
    public $timestamps = false;

    protected $fillable = ['user_id', 'favourite_user_id'];

     public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function favouriteUser()
    {
        return $this->belongsTo(User::class, 'favourite_user_id');
    }

}
