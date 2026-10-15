<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InvestmentPlan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'badge',
        'min_amount',
        'max_amount',
        'fixed_amount',
        'interest_rate',
        'interest_type',
        'frequency_hours',
        'frequency_label',
        'duration_type',
        'total_periods',
        'capital_back',
        'status',
        'featured',
        'description',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'min_amount' => 'decimal:8',
            'max_amount' => 'decimal:8',
            'fixed_amount' => 'decimal:8',
            'interest_rate' => 'decimal:4',
            'frequency_hours' => 'integer',
            'total_periods' => 'integer',
            'capital_back' => 'boolean',
            'featured' => 'boolean',
        ];
    }

    /**
     * Scope a query to only include active plans.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('status', 'active');
    }

    /**
     * Scope a query to only include featured plans.
     */
    public function scopeFeatured(Builder $query): void
    {
        $query->where('featured', true);
    }

    /**
     * Determine if the plan uses a fixed investment amount rather than a range.
     */
    public function isFixed(): bool
    {
        return $this->fixed_amount !== null && (float) $this->fixed_amount > 0;
    }

    /**
     * Calculate the periodic return amount for a given invested principal.
     */
    public function calculatePeriodicReturn(float|string $investedAmount): string
    {
        $principal = (float) $investedAmount;

        if ($this->interest_type === 'fixed') {
            return (string) $this->interest_rate;
        }

        // Percentage calculation
        $returnAmount = ($principal * (float) $this->interest_rate) / 100;

        return number_format($returnAmount, 8, '.', '');
    }

    /**
     * Get user investments subscribed to this plan.
     */
    public function investments(): HasMany
    {
        return $this->hasMany(UserInvestment::class, 'plan_id');
    }
}
