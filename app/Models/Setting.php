<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'display_name', 'value', 'type'];

    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = Cache::rememberForever("setting.{$key}", function () use ($key) {
            return static::where('key', $key)->first();
        });

        return $setting?->value ?? $default;
    }

    public static function set(string $key, mixed $value): bool
    {
        $setting = static::where('key', $key)->first();
        if (!$setting) return false;
        
        $setting->value = $value;
        $setting->save();
        Cache::forget("setting.{$key}");
        
        return true;
    }

    protected static function booted(): void
    {
        static::saved(fn ($s) => Cache::forget("setting.{$s->key}"));
        static::deleted(fn ($s) => Cache::forget("setting.{$s->key}"));
    }
}
