<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BaseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BaseModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BaseModel query()
 * @mixin \Eloquent
 */
class BaseModel extends Model
{
    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $model->clean();
        });

        self::updating(function($model){
            $model->clean();
        });
    }
    
    /**
     * Cleans the model before saving changes to database.
     *
     * @return void
     */
    public function clean(){ }
}
