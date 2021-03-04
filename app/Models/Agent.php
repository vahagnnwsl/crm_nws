<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Agent extends Model
{
    use HasFactory, LogsActivity;

    protected static $logAttributes = ['first_name', 'last_name', 'email', 'phone', 'telegram', 'skype'];

    protected $fillable = [
        'creator_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'telegram',
        'skype'
    ];

    /**
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'creator_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'agent_id');
    }

}
