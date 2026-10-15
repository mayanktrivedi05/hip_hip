<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserInvestment extends Model
{
    use HasFactory;

    public const STATUS_ACTIVE = 'active';

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_CANCELLED = 'cancelled';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'plan_id',
        'invested_amount',
        'return_per_period',
        'total_periods',
        'periods_received',
        'total_returned',
        'next_payout_at',
        'status',
        'capital_returned_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'invested_amount' => 'decimal:8',
            'return_per_period' => 'decimal:8',
            'total_returned' => 'decimal:8',
            'total_periods' => 'integer',
            'periods_received' => 'integer',
            'next_payout_at' => 'datetime',
            'capital_returned_at' => 'datetime',
        ];
    }

    /**
     * Get the user that made the investment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the investment plan definition.
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(InvestmentPlan::class, 'plan_id');
    }

    /**
     * Scope active investments.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope investments that are due for ROI distribution.
     */
    public function scopeDueForPayout(Builder $query): void
    {
        $query->where('status', self::STATUS_ACTIVE)
            ->whereNotNull('next_payout_at')
            ->where('next_payout_at', '<=', now());
    }

    /**
     * Calculate lifecycle progress percentage.
     */
    public function progressPercentage(): int
    {
        if ($this->total_periods <= 0) {
            return 100;
        }

        return (int) min(100, round(($this->periods_received / $this->total_periods) * 100));
    }
}
