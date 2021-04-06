<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Repositories\DeveloperRepository;
use App\Http\Repositories\StackRepository;
use App\Http\Requests\DeveloperInterviewRequest;
use App\Http\Requests\DeveloperRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;


class DeveloperController extends Controller
{

    /**
     * @var DeveloperRepository
     */
    protected $developerRepository;

    /**
     * @var StackRepository
     */
    protected $stackRepository;

    /**
     * DeveloperController constructor.
     * @param DeveloperRepository $developerRepository
     * @param StackRepository $stackRepository
     */
    public function __construct(DeveloperRepository $developerRepository, StackRepository $stackRepository)
    {
        $this->developerRepository = $developerRepository;

        $this->stackRepository = $stackRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {


        $developers = $this->developerRepository->getAll($request->all());

        $developerStatuses = developerStatuses();

        $filterAttributes = ['creator', 'created', 'name', 'stacks', 'developer_position', 'developer_status'];

        return view('dashboard.developers.index', compact('developers', 'developerStatuses', 'filterAttributes'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $developerPositions = developerPositions();

        $stacks = collectionConvertForSelect2($this->stackRepository->getAll());

        return view('dashboard.developers.create', compact('developerPositions', 'stacks'));
    }


    /**
     * @param DeveloperRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(DeveloperRequest $request)
    {
        $developer = $this->developerRepository->store(Auth::id(), $request->validated());

        $this->developerRepository->syncStacks($developer->id, $request['stacks']);

        $this->putFlashMessage(true, 'Successfully created');

        return redirect()->route('developers.index');
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(int $id)
    {
        $developer = $this->developerRepository->getById($id);

        if (!$developer) {
            abort(404);
        }

        $developer->load('interviews');

        $developerPositions = developerPositions();

        $developerStatuses = developerStatuses();

        $stacks = collectionConvertForSelect2($this->stackRepository->getAll());

        return view('dashboard.developers.edit', compact('developer', 'developerPositions', 'developerStatuses', 'stacks'));
    }


    /**
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(int $id)
    {
        $developer = $this->developerRepository->getById($id);

        if (!$developer) {
            abort(404);
        }

        $developerStatuses = developerStatuses();

        return view('dashboard.developers.show', compact('developer', 'developerStatuses'));
    }


    /**
     * @param DeveloperRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(DeveloperRequest $request, $id)
    {
        $this->developerRepository->update($id, $request->validated());

        $this->developerRepository->syncStacks($id, $request['stacks']);

        $this->putFlashMessage(true, 'Successfully updated');

        return redirect()->back();
    }


    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id)
    {
        $resp = $this->developerRepository->destroy($id);
        $this->putFlashMessage($resp ? false : true, $resp ? $resp['msg'] : 'Successfully deleted');

        return redirect()->route('developers.index');
    }


    /**
     * @param DeveloperInterviewRequest $request
     * @param int $developer_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeInterview(DeveloperInterviewRequest $request, int $developer_id)
    {
        $this->developerRepository->storeInterview($request->validated(), $developer_id, Auth::id());
        $this->putFlashMessage(true, 'Successfully created');
        return response()->json();
    }

    /**
     * @param int $developer_id
     * @param int $interview_id
     * @return \Illuminate\Http\JsonResponse\
     */
    public function deleteInterview(int $developer_id, int $interview_id)
    {
        $this->developerRepository->deleteInterview($developer_id,$interview_id);

        $this->putFlashMessage(true, 'Successfully deleted');

        return response()->json();
    }
}
