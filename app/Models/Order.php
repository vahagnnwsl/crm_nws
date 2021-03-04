<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Order extends Model
{
    use HasFactory,LogsActivity;


    protected $fillable = [
        'name',
        'description',
        'source',
        'link',
        'creator_id',
        'agent_id',
        'status',
        'stacks',
        'budget',
        'currency',
        'hash'
    ];

    protected static $logAttributes = ['name', 'description', 'source','link','agent_id','status','stacks','budget','currency'];

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function agent()
    {
        return $this->hasOne(Agent::class, 'id', 'agent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function people()
    {
        return $this->hasMany(OrderPerson::class, 'order_id');
    }


}
