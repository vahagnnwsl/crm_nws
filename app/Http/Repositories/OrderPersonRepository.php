<?php

namespace App\Http\Repositories;

use App\Models\OrderPerson;

class OrderPersonRepository
{


    /**
     * @param array $requestData
     * @param int $creator_id
     */
    public function store(array $requestData, int $creator_id): void
    {
        $requestData['creator_id'] = $creator_id;
        OrderPerson::create($requestData);

    }


}
