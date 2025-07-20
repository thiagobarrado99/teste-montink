<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $order_id
 * @property int|null $product_id
 * @property int $is_discount
 * @property string $description
 * @property string $total
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Order $order
 * @property-read \App\Models\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderTotal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderTotal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderTotal query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderTotal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderTotal whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderTotal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderTotal whereIsDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderTotal whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderTotal whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderTotal whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderTotal whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrderTotal extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        "order_id",
        "product_id",
        "is_discount",
        "description",
        "total",
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
    
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
