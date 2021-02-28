<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderPersonRequest;
use App\Http\Repositories\OrderPersonRepository;
use Illuminate\Support\Facades\Auth;

class OrderPersonController extends Controller
{

    /**
     * @var OrderPersonRepository
     */
    protected $orderPersonRepository;

    /**
     * OrderPersonController constructor.
     * @param OrderPersonRepository $orderPersonRepository
     */
    public function __construct(OrderPersonRepository $orderPersonRepository)
    {
        $this->orderPersonRepository = $orderPersonRepository;
    }

    /**
     * @param OrderPersonRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(OrderPersonRequest $request)
    {
        $this->orderPersonRepository->store($request->validated(), Auth::id());

        $this->putFlashMessage(true, 'Successfully created');

        return response()->json([]);
    }


}
