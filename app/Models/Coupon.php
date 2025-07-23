<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

/**
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int $is_percentage
 * @property string $discount_value
 * @property string|null $minimum_price
 * @property int|null $max_uses
 * @property int $total_uses
 * @property \Illuminate\Support\Carbon $expires_at
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereDiscountValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereIsPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereMaxUses($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereMinimumPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereTotalUses($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereUserId($value)
 * @mixin \Eloquent
 */
class Coupon extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        "name",
        "code",
        "is_percentage",
        "discount_value",
        "minimum_price",
        "max_uses",
        "total_uses",
        "expires_at",
        "user_id"
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
        ];
    }

    public function clean(bool $assign_user = false): void
    {
        parent::clean(true);

        $this->discount_value = money_unformat($this->discount_value);
        $this->minimum_price = money_unformat($this->minimum_price);
    }

    /**
     * Get the minimum amount formatted
     *
     * @return string
     */
    public function minimumFormatted(): string
    {
        return $this->minimum_price ? money_format($this->minimum_price) : "";
    }

    /**
     * Get the discount amount formatted
     *
     * @return string
     */
    public function discountFormatted(): string
    {
        return $this->is_percentage ? round($this->discount_value, 0) . "%" : money_format($this->discount_value);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
