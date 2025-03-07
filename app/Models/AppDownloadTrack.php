<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppDownloadTrack extends Model
{
    protected $fillable = ['ip_address', 'status', 'completed_at'];

    public static function track($ipAddress)
{
    self::create([
        'ip_address' => $ipAddress,
    ]);
}

}
