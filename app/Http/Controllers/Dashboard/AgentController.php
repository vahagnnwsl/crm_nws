<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Repositories\AgentRepository;
use App\Http\Requests\AgentRequest;
use App\Http\Requests\OrderPersonRequest;
use App\Http\Repositories\OrderPersonRepository;
use App\Http\Resources\OrderPerson;
use Illuminate\Support\Facades\Auth;

class AgentController extends Controller
{

    /**
     * @var AgentRepository
     */
    protected $agentRepository;

    /**
     * AgentController constructor.
     * @param AgentRepository $agentRepository
     */
    public function __construct(AgentRepository $agentRepository)
    {
        $this->agentRepository = $agentRepository;
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $agents = $this->agentRepository->getAll();

        return view('dashboard.agents.index', compact('agents'));

    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('dashboard.agents.create');

    }

    /**
     * @param AgentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AgentRequest $request)
    {
        $this->agentRepository->store($request->validated(), Auth::id());

        $this->putFlashMessage(true, 'Successfully created');

        return redirect()->route('agents.index');
    }


    /**
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(int $id)
    {

        $agent = $this->agentRepository->getById($id);

        if (!$agent) {
            abort(404);
        }

        return view('dashboard.agents.edit', compact('agent'));

    }

    /**
     * @param AgentRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AgentRequest $request, int $id)
    {

        $this->agentRepository->update($request->validated(), $id);

        $this->putFlashMessage(true, 'Successfully updated');

        return redirect()->back();

    }

    public function destroy(int $id)
    {

        $resp = $this->agentRepository->destroy($id);

        $this->putFlashMessage($resp ? false : true, $resp ? $resp['msg'] : 'Successfully deleted');

        return redirect()->route('agents.index');

    }

}
