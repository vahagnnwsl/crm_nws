<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeveloperInterview extends Model
{
    use HasFactory;

    protected $fillable = [
        'developer_id',
        'creator_id',
        'test_name',
        'test_result',
        'interviewer',
        'date',
        'position',

    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'date' => 'datetime:Y-m-d'
    ];
}
