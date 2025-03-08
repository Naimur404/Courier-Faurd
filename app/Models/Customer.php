<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = [
        'phone',
        'count',
        'data',
        'search_by',
        'ip_address',
        'last_searched_at',
    ];
}
