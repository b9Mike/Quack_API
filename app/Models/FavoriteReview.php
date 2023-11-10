<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FavoriteReview extends Model
{
    use HasFactory, SoftDeletes;

    protected $table =  'favorite_reviews';

    public $timestamps = false;
    
    protected $fillable = [
        'user_id',
        'review_id'
    ];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function review() {
        return $this->hasOne(Review::class, 'id', 'review_id');
    }

}
