<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SearchHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'customer_id',
        'search_by',
        'ip_address',
        'result_summary',
        'searched_at',
    ];

    protected $casts = [
        'result_summary' => 'array',
        'searched_at' => 'datetime',
    ];

    /**
     * Get the user who performed the search
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the customer record (phone data)
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Record a search
     */
    public static function recordSearch(
        int $userId,
        string $phone,
        ?int $customerId = null,
        string $searchBy = 'web',
        ?string $ipAddress = null,
        ?array $resultSummary = null
    ): self {
        return self::create([
            'user_id' => $userId,
            'phone' => $phone,
            'customer_id' => $customerId,
            'search_by' => $searchBy,
            'ip_address' => $ipAddress,
            'result_summary' => $resultSummary,
            'searched_at' => now('Asia/Dhaka'),
        ]);
    }

    /**
     * Get user's recent searches
     */
    public static function getUserSearchHistory(int $userId, int $limit = 20)
    {
        return self::where('user_id', $userId)
            ->with('customer')
            ->orderBy('searched_at', 'desc')
            ->take($limit)
            ->get();
    }
}
