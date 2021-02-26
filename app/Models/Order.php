<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'source',
        'link',
        'creator_id',
        'status',
        'stacks',
        'budget',
        'currency',
        'hash'
    ];


    public function setStacksAttribute($value)
    {
        $this->attributes['stacks'] = json_encode($value);
    }

    public function getStacksAttribute($value)
    {
        return json_decode($value);
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $model->update(['hash' => md5($model->id . $model->creaded_at . time())]);
        });

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'creator_id');
    }
}
