<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LinkedinMessage extends JsonResource
{


    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'conversation_id' => $this->conversation_id,
            'conversation_entityUrn' => $this->conversation_entityUrn,
            'entityUrn' => $this->entityUrn,
            'user_entityUrn' => $this->user_entityUrn,
            'text' => $this->text,
            'date_diff' => $this->date->diffForHumans(),
            'date' => $this->date,
            'status' => $this->status,
            'event' => $this->event,
            'hash' => $this->hash,
            'attachments' => $this->attachments,
            'media' => $this->media,
        ];
    }
}
