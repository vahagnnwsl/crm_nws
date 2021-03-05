<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatusComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'creator_id',
        'comment',
        'status',
        'attachment'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'creator_id');
    }


    /**
     * @return string
     */
    public function getFileAttribute(): string
    {
        if ($this->attachment) {
            return "/storage/{$this->attachment}";
        }

        return '';

    }

}
