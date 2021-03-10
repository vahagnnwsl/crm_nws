<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Order extends Model
{
    use HasFactory, LogsActivity;


    protected $fillable = [
        'name',
        'description',
        'source',
        'link',
        'creator_id',
        'expert_id',
        'developer_id',
        'team_lid_id',
        'agent_id',
        'status',
        'budget',
        'currency',
        'hash'
    ];


    /**
     * @var string[]
     */
    protected static $logAttributes = ['name', 'description', 'source', 'link', 'agent_id', 'status', 'stacks', 'budget', 'currency'];

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function expert()
    {
        return $this->hasOne(Developer::class, 'id','expert_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function developer()
    {
        return $this->hasOne(Developer::class, 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function teamLead()
    {
        return $this->hasOne(Developer::class, 'id','team_lid_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function statusComments()
    {

        return $this->hasMany(OrderStatusComment::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function stacks()
    {
        return $this->belongsToMany(Stack::class, 'order_stacks');
    }

}
