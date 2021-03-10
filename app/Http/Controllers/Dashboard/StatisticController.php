<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Repositories\StatisticRepository;
use ReflectionClass;

class StatisticController extends Controller
{
    /**
     * @var StatisticRepository
     */
    protected $statisticRepository;

    /**
     * StatisticController constructor.
     * @param StatisticRepository $statisticRepository
     */
    public function __construct(StatisticRepository $statisticRepository)
    {
        $this->statisticRepository = $statisticRepository;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {

        $getUsersOrdersGroupMonth = $this->statisticRepository->getUsersOrdersGroupMonth();


        $getUsersOrdersByAllTime = $this->statisticRepository->getUsersOrdersByAllTime();

        return view('dashboard.statistic.index', compact('getUsersOrdersByAllTime', 'getUsersOrdersGroupMonth'));
    }


}
