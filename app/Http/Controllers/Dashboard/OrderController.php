<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\DTO\PermissionDto;
use App\Http\Repositories\OrderRepository;
use App\Http\Repositories\PermissionRepository;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    /**
     * @var OrderRepository
     */
    protected $orderRepository;

    /**
     * OrderController constructor.
     * @param OrderRepository $orderRepository
     */
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $orders = $this->orderRepository->getAll();

        return view('dashboard.orders.index', compact('orders'));
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {

        $sources = orderSources();
        $stacks = stacksForSelect2();
        $currencies = currencies();


        return view('dashboard.orders.create', compact('sources', 'stacks', 'currencies'));

    }


    /**
     * @param OrderRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(OrderRequest $request)
    {

        $data = $request->validated();
        $data['creator_id'] = Auth::id();

        $this->orderRepository->store($data);

        $this->putFlashMessage(true, 'Successfully created');

        return redirect()->back();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id) {

        $order = $this->orderRepository->getById($id);

        if (!$order) {
            abort(404);
        }

        $sources = orderSources();
        $stacks = stacksForSelect2();
        $currencies = currencies();

        return view('dashboard.orders.edit', compact('sources', 'stacks', 'currencies','order'));

    }


}
