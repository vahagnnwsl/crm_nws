<?php

namespace App\Http\Repositories;

use App\Models\Order;
use App\Models\Stack;
use App\Models\User;

class StatisticRepository
{

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var OrderRepository
     */
    protected $orderRepository;

    /**
     * StatisticRepository constructor.
     * @param UserRepository $userRepository
     * @param OrderRepository $orderRepository
     */
    public function __construct(UserRepository $userRepository, OrderRepository $orderRepository)
    {
        $this->userRepository = $userRepository;
        $this->orderRepository = $orderRepository;
    }

    public function getUsersOrdersByAllTime(): array
    {
        $array = [
            'labels' => [],
            'backgroundColor' => [],
            'data' => []
        ];


        foreach ($this->userRepository->getAllWithOrdersCount() as $user) {
            array_push($array['labels'], $user->fullName);
            array_push($array['backgroundColor'], $user->color);
            array_push($array['data'], $user->orders_count);
        }

        return $array;
    }

    public function getUsersOrdersGroupMonth(): array
    {

        $array = [
            'data' => [],
            'labels' => [],
        ];

        $data = $this->orderRepository->getOrdersCountGroupMonthAndCreator();

        foreach ($data as $item) {
            if (!isset($array['data'][$item->creator_id])) {
                $array['data'][$item->creator_id] = [
                    'label' => '',
                    'backgroundColor' => '',
                    'data' => [],
                ];
            }

            if (!in_array($item->date, $array['labels'])) {
                array_push($array['labels'], $item->date);
            }

            $array['data'][$item->creator_id]['label'] = $item->creator->fullName;
            $array['data'][$item->creator_id]['backgroundColor'] = $item->creator->color;

            array_push($array['data'][$item->creator_id]['data'], $item->data);

        }

        $arr = [];

        foreach ($array['data'] as $item) {
            array_push($arr, $item);
        }



        return [
            'data' => $arr,
            'labels' => $array['labels']
        ];
    }
}
