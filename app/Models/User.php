<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

#[Fillable(['name', 'email', 'password', 'role', 'email_verified_at', 'referral_code', 'referred_by'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Boot the model to handle automatic wallet creation and referral code generation.
     */
    protected static function booted(): void
    {
        static::creating(function (User $user) {
            if (empty($user->referral_code)) {
                $user->referral_code = strtoupper(Str::random(8));
            }
        });

        static::created(function (User $user) {
            // Automatically initialize the 3 financial wallets
            $user->wallets()->createMany([
                ['type' => Wallet::TYPE_MAIN, 'balance' => 0.00000000],
                ['type' => Wallet::TYPE_PROFIT, 'balance' => 0.00000000],
                ['type' => Wallet::TYPE_REFERRAL, 'balance' => 0.00000000],
            ]);
        });
    }

    /**
     * Wallets owned by the user.
     */
    public function wallets(): HasMany
    {
        return $this->hasMany(Wallet::class);
    }

    /**
     * User's investments in plans.
     */
    public function investments(): HasMany
    {
        return $this->hasMany(UserInvestment::class);
    }

    /**
     * User's ledger transactions.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * User's deposit requests.
     */
    public function deposits(): HasMany
    {
        return $this->hasMany(Deposit::class);
    }

    /**
     * User's withdrawal requests.
     */
    public function withdrawals(): HasMany
    {
        return $this->hasMany(Withdrawal::class);
    }

    /**
     * The user who referred this member.
     */
    public function referrer(): BelongsTo
    {
        return $this->belongsTo(self::class, 'referred_by');
    }

    /**
     * Members referred by this user.
     */
    public function referrals(): HasMany
    {
        return $this->hasMany(self::class, 'referred_by');
    }

    /**
     * Retrieve or create a specific wallet by type.
     */
    public function getWallet(string $type = Wallet::TYPE_MAIN): Wallet
    {
        return $this->wallets()->firstOrCreate(
            ['type' => $type],
            ['balance' => 0.00000000]
        );
    }

    /**
     * Quick helper for Main Wallet.
     */
    public function mainWallet(): Wallet
    {
        return $this->getWallet(Wallet::TYPE_MAIN);
    }

    /**
     * Quick helper for Profit Wallet.
     */
    public function profitWallet(): Wallet
    {
        return $this->getWallet(Wallet::TYPE_PROFIT);
    }

    /**
     * Quick helper for Referral Wallet.
     */
    public function referralWallet(): Wallet
    {
        return $this->getWallet(Wallet::TYPE_REFERRAL);
    }

    /**
     * Formatted string balances.
     */
    public function mainBalance(): string
    {
        return $this->mainWallet()->formattedBalance();
    }

    public function profitBalance(): string
    {
        return $this->profitWallet()->formattedBalance();
    }

    public function referralBalance(): string
    {
        return $this->referralWallet()->formattedBalance();
    }

    /**
     * Total amount currently invested in active plans.
     */
    public function totalInvested(): string
    {
        $sum = $this->investments()
            ->where('status', UserInvestment::STATUS_ACTIVE)
            ->sum('invested_amount');

        return number_format((float) $sum, 2);
    }

    /**
     * Determine if the user has one of the specified roles.
     *
     * @param  string|array<int, string>  $roles
     */
    public function hasRole(string|array $roles): bool
    {
        $roleList = is_array($roles) ? $roles : func_get_args();

        return in_array($this->role, $roleList, true);
    }

    /**
     * Check if user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is a moderator.
     */
    public function isModerator(): bool
    {
        return $this->role === 'moderator';
    }

    /**
     * Check if user is a standard user.
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }
}
