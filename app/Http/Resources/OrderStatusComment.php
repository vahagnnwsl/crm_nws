<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderStatusComment extends JsonResource
{


    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'text' => $this->comment,
            'status' => $this->status,
            'attachment' => $this->file,
            'creator' => [
                'fullName' => $this->creator->fullName,
                'avatar' => $this->creator->image
            ],
            'date' => $this->created_at->format('d.m.Y H:m')
        ];
    }
}
