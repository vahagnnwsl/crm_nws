<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Repositories\StatisticRepository;
use Illuminate\Http\Request;
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
    public function indexOrders()
    {
        return view('dashboard.statistic.index-orders');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function indexUsers()
    {
        return view('dashboard.statistic.index-users');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUsersOrders(Request $request)
    {
        return response()->json($this->statisticRepository->getUsersOrders($request->get('date')));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUsersOrdersGroupByMonth(Request $request)
    {
        return response()->json($this->statisticRepository->getUsersOrdersGroupMonth($request->get('date')));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUsersOrdersGroupByStatus(Request $request)
    {
        return response()->json($this->statisticRepository->getUsersOrdersGroupByStatus($request->get('date')));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSingleUserOrdersGroupByStatus(Request $request)
    {
        return response()->json($this->statisticRepository->getSingleUserOrdersGroupByStatus($request->get('date')));
    }

}


