<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $total
 * @property int $client_id
 * @property int|null $coupon_id
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Client $client
 * @property-read \App\Models\Coupon|null $coupon
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderTotal> $orderTotals
 * @property-read int|null $order_totals_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCouponId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Order extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        "total",
        "status",
        "client_id",
        "coupon_id",
    ];

    public const STATUS_PENDING = 0;
    public const STATUS_PAID = 1;
    public const STATUS_SHIPPED = 2;
    public const STATUS_FINISHED = 3;
    public const STATUS_CANCELED = 4;

    public static $statusLabels = [
        Order::STATUS_PENDING => "Pendente",
        Order::STATUS_PAID => "Pago",
        Order::STATUS_SHIPPED => "Enviado",
        Order::STATUS_FINISHED => "Finalizado",
        Order::STATUS_CANCELED => "Cancelado"
    ];

    public function statusLabel()
    {
        return Order::$statusLabels[$this->status];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public function orderTotals(): HasMany
    {
        return $this->hasMany(OrderTotal::class);
    }
}
