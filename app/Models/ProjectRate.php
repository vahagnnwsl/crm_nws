<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'creator_id',
        'project_id',
        'budget',
        'date',
        'currency',
        'default'
    ];

    protected $casts = [
        'date' => 'datetime:Y-m-d'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'creator_id');
    }
}
