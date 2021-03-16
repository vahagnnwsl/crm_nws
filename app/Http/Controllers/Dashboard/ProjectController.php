<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Repositories\AgentRepository;
use App\Http\Repositories\DeveloperRepository;
use App\Http\Repositories\ProjectRepository;
use App\Http\Repositories\StackRepository;
use App\Http\Requests\ProjectPaymentRequest;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectPaymentCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProjectController extends Controller
{

    /**
     * @var ProjectRepository
     */
    protected $projectRepository;

    /**
     * @var StackRepository
     */
    protected $stackRepository;

    /**
     * @var AgentRepository
     */
    protected $agentRepository;

    /**
     * @var DeveloperRepository
     */
    protected $developerRepository;

    /**
     * ProjectController constructor.
     * @param ProjectRepository $projectRepository
     * @param AgentRepository $agentRepository
     * @param StackRepository $stackRepository
     * @param DeveloperRepository $developerRepository
     */
    public function __construct(ProjectRepository $projectRepository, AgentRepository $agentRepository, StackRepository $stackRepository, DeveloperRepository $developerRepository)
    {
        $this->projectRepository = $projectRepository;
        $this->stackRepository = $stackRepository;
        $this->agentRepository = $agentRepository;
        $this->developerRepository = $developerRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $projects = $this->projectRepository->getAll($request->all());
        return view('dashboard.projects.index', compact('projects'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(int $id)
    {
        $agents = $this->agentRepository->getAll();

        $sources = orderSources();

        $stacks = collectionConvertForSelect2($this->stackRepository->getAll());

        $currencies = currencies();

        $developers = $this->developerRepository->getAccepted();

        $project = $this->projectRepository->getById($id);

        return view('dashboard.projects.edit', compact('project', 'sources', 'stacks', 'currencies', 'agents', 'developers'));

    }

    /**
     * @param ProjectRequest $projectRequest
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProjectRequest $request, int $id)
    {
        $this->projectRepository->update($request->validated(), $id);
        $this->projectRepository->setStacks($id, $request['stacks']);

        $this->putFlashMessage(true, 'Successfully updated');

        return redirect()->back();
    }


    /**
     * @param ProjectPaymentRequest $request
     * @param int $project_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function storePayment(ProjectPaymentRequest $request, int $project_id)
    {
        $this->projectRepository->storePayment(array_merge($request->validated(), ['creator_id' => Auth::id()]), $project_id);
        return response()->json([]);
    }


    /**
     * @param int $id
     * @return ProjectPaymentCollection
     */
    public function getPayments(int $id)
    {
        return new ProjectPaymentCollection($this->projectRepository->getPayments($id));
    }

    /**\
     * @param int $project_id
     * @param int $payment_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deletePayment(int $project_id, int $payment_id)
    {
        $this->projectRepository->deletePayment($project_id, $payment_id);
        return response()->json([]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeRate(Request $request, $id)
    {
        $this->putFlashMessage(true,'Success');

        return response()->json(['rates' => $this->projectRepository->storeRate($id, $request->get('rates'),Auth::id())]);
    }


}
