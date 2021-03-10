<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, LogsActivity;


    /**
     * @var string[]
     */
    protected static $logAttributes = ['first_name', 'last_name', 'status', 'avatar'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'status',
        'email',
        'password',
        'avatar',
        'invitation_token',
        'color'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'invitation_token',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * @return string
     */
    public function getImageAttribute(): string
    {
        if ($this->avatar) {
            return "/storage/{$this->avatar}";
        }

        return '/dist/img/avatar5.png';

    }

    /**
     * @return bool
     */
    public function getIsAcceptedInvitationAttribute(): bool
    {

        if (!$this->status && $this->invitation_token) {
            return false;
        }

        return true;
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function timeline()
    {
        return $this->morphMany(Activity::class, 'causer');
    }

    public function getNameForLogAttribute()
    {
        return $this->full_name;
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'creator_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agents()
    {
        return $this->hasMany(Agent::class, 'creator_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function developers()
    {
        return $this->hasMany(Developer::class, 'creator_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderPersons()
    {
        return $this->hasMany(OrderPerson::class, 'creator_id');
    }

}
