<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Transaction extends Model
{
    use HasFactory;

    public const TYPE_DEPOSIT = 'deposit';

    public const TYPE_INVESTMENT = 'investment';

    public const TYPE_ROI_PAYOUT = 'roi_payout';

    public const TYPE_WITHDRAWAL = 'withdrawal';

    public const TYPE_REFERRAL_BONUS = 'referral_bonus';

    public const TYPE_TRANSFER = 'transfer';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'wallet_id',
        'type',
        'amount',
        'fee',
        'post_balance',
        'tx_hash',
        'description',
        'status',
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
            'fee' => 'decimal:8',
            'post_balance' => 'decimal:8',
        ];
    }

    /**
     * Generate a unique transaction reference hash.
     */
    public static function generateTxHash(string $prefix = 'TXN'): string
    {
        return strtoupper($prefix.'_'.Str::random(16));
    }

    /**
     * Get the user that owns the transaction.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the wallet associated with the transaction.
     */
    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }
}
