<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Developer extends Model
{
    use HasFactory, LogsActivity;

    protected static $logAttributes = ['first_name', 'last_name', 'email', 'phone', 'cv', 'position', 'status'];

    protected $fillable = [
        'creator_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'cv',
        'position',
        'status',
        'stacks'
    ];

    /**
     * @param $value
     */
    public function setStacksAttribute($value)
    {
        $this->attributes['stacks'] = json_encode($value);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getStacksAttribute($value)
    {
        return json_decode($value);
    }



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
     * @param $value
     * @return string
     */
    public function getCvAttribute($value): string
    {
        if ($value) {
            return "/storage/{$value}";
        }

        return '';
    }


}
