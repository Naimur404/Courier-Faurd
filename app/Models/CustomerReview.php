<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerReview extends Model
{
    protected $table = 'customer_reviews';

    protected $fillable = [
        'phone',
        'commenter_phone',
        'customer_id',
        'name',
        'rating',
        'comment',
    ];
}
