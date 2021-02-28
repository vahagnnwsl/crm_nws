<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPerson extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'creator_id',
        'first_name',
        'last_name',
        'position',
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

}
