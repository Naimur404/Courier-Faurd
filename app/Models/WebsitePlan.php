<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsitePlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'duration_days',
        'icon',
        'color',
        'features',
        'is_popular',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'duration_days' => 'integer',
        'features' => 'array',
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get only active plans ordered by sort_order
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    /**
     * Get formatted price in Bengali
     */
    public function getFormattedPriceAttribute(): string
    {
        return '৳' . number_format($this->price, 0);
    }

    /**
     * Get duration text in Bengali
     */
    public function getDurationTextAttribute(): string
    {
        if ($this->duration_days == 1) {
            return '১ দিন';
        } elseif ($this->duration_days == 7) {
            return '৭ দিন';
        } elseif ($this->duration_days == 15) {
            return '১৫ দিন';
        } elseif ($this->duration_days == 30) {
            return '৩০ দিন';
        }
        return $this->duration_days . ' দিন';
    }
}
