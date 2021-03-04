<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderPersonRequest;
use App\Http\Repositories\OrderPersonRepository;
use App\Http\Resources\OrderPerson;
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


    /**
     * @param int $id
     * @return OrderPerson
     */
    public function get(int $id)
    {
        $orderPerson = $this->orderPersonRepository->getById($id);

        return new OrderPerson($orderPerson);
    }

    /**
     * @param OrderPersonRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(OrderPersonRequest $request, int $id)
    {
        $this->orderPersonRepository->update($request->validated(), $id);

        $this->putFlashMessage(true, 'Successfully updated');

        return response()->json([]);
    }


}
