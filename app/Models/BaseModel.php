<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
    public function clean(bool $assign_user = false){
        if($assign_user && Auth::check()){
            $this->user_id = Auth::user()->id;
        }
    }
}
