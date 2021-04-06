<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkedinConversation extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'entityUrn',
        'unreadCount',
        'data',
        'lastActivityAt',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'data' => 'array',
        'lastActivityAt' => 'datetime:Y-m-d H:m'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(LinkedinMessage::class, 'conversation_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'linkedin_conversation_users','conversation_id','user_id');
    }
}
