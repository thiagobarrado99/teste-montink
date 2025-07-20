<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read \App\Models\Inventory|null $inventory
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryHistory query()
 * @mixin \Eloquent
 */
class InventoryHistory extends Model
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

    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
