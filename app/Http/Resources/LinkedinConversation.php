<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LinkedinConversation extends JsonResource
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
            'entityUrn' => $this->entityUrn,
            'data' => $this->data,
            'lastActivityAt' => $this->lastActivityAt,
            'lastActivityAt_diff' => $this->lastActivityAt->diffForHumans(),

        ];
    }
}
