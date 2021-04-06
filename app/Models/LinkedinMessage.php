<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkedinMessage extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'conversation_id',
        'conversation_entityUrn',
        'user_entityUrn',
        'text',
        'entityUrn',
        'date',
        'hash',
        'status',
        'event',
        'media',
        'attachments',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'date' => 'datetime:Y-m-d H:m',
        'media' => 'array',
        'attachments' => 'array',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function conversation(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(LinkedinConversation::class, 'id', 'conversation_id');
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $model->update(['hash' => md5($model->id)]);
            $model->conversation->update(['lastActivityAt'=>Carbon::now()->toDateTimeString()]);
        });

    }
}
