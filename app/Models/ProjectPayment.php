<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectPayment extends Model
{
    use HasFactory;


    protected $fillable = [
        'creator_id',
        'project_id',
        'budget',
        'date',
        'currency',
        'invoice'
    ];

    protected $casts = [
        'date' => 'datetime'
    ];

    /**
     * @return string
     */
    public function getAmountAttribute(){
        return "{$this->budget} {$this->currency}";
    }


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
    public function getAttachmentAttribute(): string
    {
        if ($this->invoice) {
            return "/storage/{$this->invoice}";
        }
        return '';

    }

}
