<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

/**
 * @property int $id
 * @property int $type
 * @property float|null $range_start
 * @property float|null $range_end
 * @property float $price
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingRule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingRule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingRule query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingRule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingRule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingRule wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingRule whereRangeEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingRule whereRangeStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingRule whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingRule whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingRule whereUserId($value)
 * @mixin \Eloquent
 */
class ShippingRule extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        "type",
        "range_start",
        "range_end",
        "price",
        "user_id"
    ];

    public static $typeLabels = [
        "0" => "Menor que X",
        "1" => "Maior que X",
        "2" => "Entre X e Y"
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [

        ];
    }

    public function typeLabel()
    {
        return ShippingRule::$typeLabels[$this->type];
    }

    public function clean(bool $assign_user = false): void
    {
        parent::clean(true);

        $this->range_start = money_unformat($this->range_start);
        $this->range_end = money_unformat($this->range_end);
        $this->price = money_unformat($this->price);
    }

    /**
     * Get the range start amount formatted
     *
     * @return string
     */
    public function startFormatted(): string
    {
        return $this->range_start ? money_format($this->range_start) : "";
    }

    /**
     * Get the range end amount formatted
     *
     * @return string
     */
    public function endFormatted(): string
    {
        return $this->range_end ? money_format($this->range_end) : "";
    }

    /**
     * Get the shipping price amount formatted
     *
     * @return string
     */
    public function priceFormatted(): string
    {
        return $this->price ? money_format($this->price) : "";
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
