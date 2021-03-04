<?php

namespace App\Http\Repositories;

use App\Models\Order;

class OrderRepository
{

    const STATUS_SANDED = 0;
    const STATUS_PENDING = 1;
    const STATUS_INTERVIEW = 2;
    const STATUS_COMPLETE_FORM = 3;
    const STATUS_CODE_EXAMPLE = 4;
    const STATUS_TEST_TASK = 5;
    const STATUS_CONVERSATION = 6;
    const STATUS_NOT_REMOTE = 7;
    const STATUS_DECLINE = 8;
    const STATUS_FIRST_CALL = 9;
    const STATUS_SECOND_CALL = 10;
    const STATUS_OFFER = 11;


    /**
     * @return mixed
     */
    public function getAll()
    {
        return Order::paginate(15);
    }


    /**
     * @param array $requestData
     * @return mixed
     */
    public function store(array $requestData)
    {
        return Order::create($requestData);
    }


    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id)
    {
        return Order::whereId($id)->first();
    }

    /**
     * @param array $requestData
     * @param int $id
     */
    public function update(array $requestData, int $id): void
    {
        $order = $this->getById($id);

        if ($order) {
            $order->update($requestData);
        }

    }

    /**
     * @param int $id
     */
    public function destroy(int $id): void
    {

        $order = $this->getById($id);

        $order->people()->delete();

        $order->delete();
    }

}
