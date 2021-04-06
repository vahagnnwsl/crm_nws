<?php

namespace App\Http\Resources\Collections;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LinkedinConversationCollection extends ResourceCollection
{

    /**
     * @var string
     */
    public $collects = 'App\Http\Resources\LinkedinConversation';

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);

    }
}
