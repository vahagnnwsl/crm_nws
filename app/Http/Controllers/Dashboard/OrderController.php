<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Repositories\AgentRepository;
use App\Http\Repositories\DeveloperRepository;
use App\Http\Repositories\OrderRepository;
use App\Http\Repositories\StackRepository;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\OrderStatusRequest;
use App\Http\Resources\OrderStatusCommentCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    /**
     * @var OrderRepository
     */
    protected $orderRepository;

    /**
     * @var AgentRepository
     */
    protected $agentRepository;

    /**
     * @var DeveloperRepository
     */
    protected $developerRepository;

    /**
     * @var StackRepository
     */
    protected $stackRepository;

    /**
     * OrderController constructor.
     * @param OrderRepository $orderRepository
     * @param AgentRepository $agentRepository
     * @param DeveloperRepository $developerRepository
     * @param StackRepository $stackRepository
     */
    public function __construct(OrderRepository $orderRepository, AgentRepository $agentRepository, DeveloperRepository $developerRepository, StackRepository $stackRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->agentRepository = $agentRepository;
        $this->developerRepository = $developerRepository;
        $this->stackRepository = $stackRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {

        $orders = $this->orderRepository->getAll($request->all());
        $statuses = orderStatuses();
        $filterAttributes = ['order_source', 'developer', 'order_status', 'agent', 'creator', 'created', 'name', 'stacks'];

        return view('dashboard.orders.index', compact('orders', 'statuses', 'filterAttributes'));
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {

        $sources = orderSources();

        $currencies = currencies();

        $developers = $this->developerRepository->getAccepted();

        $agents = $this->agentRepository->getAll();

        $stacks = collectionConvertForSelect2($this->stackRepository->getAll());

        return view('dashboard.orders.create', compact('sources', 'stacks', 'currencies', 'agents', 'developers'));

    }


    /**
     * @param OrderRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(OrderRequest $request)
    {

        $data = $request->validated();

        $data['creator_id'] = Auth::id();

        $order = $this->orderRepository->store($data);

        $this->orderRepository->syncStacks($order->id, $data['stacks']);

        $this->putFlashMessage(true, 'Successfully created');

        return redirect()->route('orders.edit', $order->id);
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(int $id)
    {

        $order = $this->orderRepository->getById($id);

        if (!$order) {
            abort(404);
        }

        $agents = $this->agentRepository->getAll();

        $sources = orderSources();

        $stacks = collectionConvertForSelect2($this->stackRepository->getAll());

        $currencies = currencies();

        $statuses = orderStatuses();

        $developers = $this->developerRepository->getAccepted();

        return view('dashboard.orders.edit', compact('statuses', 'sources', 'stacks', 'currencies', 'order', 'agents', 'developers'));

    }


    /**
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View]
     */
    public function show(int $id)
    {
        $order = $this->orderRepository->getById($id);

        if (!$order) {
            abort(404);
        }

        $statuses = orderStatuses();

        return view('dashboard.orders.show', compact('statuses', 'order'));
    }


    /**
     * @param OrderRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(OrderRequest $request, $id)
    {

        $this->orderRepository->update($request->validated(), $id);

        $this->orderRepository->syncStacks($id, $request['stacks']);

        $this->putFlashMessage(true, 'Successfully updated');

        return redirect()->route('orders.edit', $id);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id)
    {
        $resp =$this->orderRepository->destroy($id);

        $this->putFlashMessage($resp ? false : true, $resp ? $resp['msg'] : 'Successfully deleted');

        return redirect()->route('orders.index');
    }

    /**
     * @param OrderStatusRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(OrderStatusRequest $request, int $id)
    {

        $this->orderRepository->updateStatus($request->validated(), $id, Auth::id());

        return response()->json([]);
    }


    /**
     * @param int $id
     * @return OrderStatusCommentCollection
     */
    public function getStatusComments(int $id)
    {
        return new OrderStatusCommentCollection($this->orderRepository->getStatusComments($id));
    }
}
