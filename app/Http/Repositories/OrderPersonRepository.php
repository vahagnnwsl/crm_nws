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


    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id)
    {
        return OrderPerson::whereId($id)->first();
    }


    /**
     * @param array $requestData
     * @param int $id
     */
    public function update(array $requestData, int $id): void
    {
        $orderPerson = $this->getById($id);

        if ($orderPerson) {
            $orderPerson->update($requestData);
        }
    }
}
