<?php

namespace App\Http\Repositories;

use App\Models\Order;

class OrderRepository
{


    /**
     * @return mixed
     */
    public function getAll()
    {
        return Order::paginate(15);
    }


    /**
     * @param array $requestData
     */
    public function store(array $requestData): void
    {
        Order::create($requestData);
    }


    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id)
    {
        return Order::whereId($id)->first();
    }

}
