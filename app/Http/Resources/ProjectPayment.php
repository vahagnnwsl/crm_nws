<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectPayment extends JsonResource
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
            'amount' => $this->amount,
            'creator' => $this->creator->fullName,
            'date' => $this->date->format('Y-m-d'),
            'attachment' => $this->attachment,
            'created_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}
