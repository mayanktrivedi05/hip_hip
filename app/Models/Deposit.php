<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Deposit extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';

    public const STATUS_APPROVED = 'approved';

    public const STATUS_REJECTED = 'rejected';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'method',
        'amount',
        'charge',
        'final_amount',
        'trx_id',
        'payment_proof',
        'status',
        'admin_feedback',
        'approved_at',
        'rejected_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:8',
            'charge' => 'decimal:8',
            'final_amount' => 'decimal:8',
            'approved_at' => 'datetime',
            'rejected_at' => 'datetime',
        ];
    }

    /**
     * Get the user that made the deposit request.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
