<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $quantity
 * @property string $description
 * @property int $inventory_id
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Inventory $inventory
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryHistory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryHistory whereInventoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryHistory whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryHistory whereUserId($value)
 * @mixin \Eloquent
 */
class InventoryHistory extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        "quantity",
        "description",
        "inventory_id",
        "user_id",
    ];

    public function clean(bool $assign_user = false): void
    {
        parent::clean(true);
    }

    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
