<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Repositories\DeveloperRepository;
use App\Http\Requests\DeveloperRequest;
use Illuminate\Support\Facades\Auth;


class DeveloperController extends Controller
{

    /**
     * @var DeveloperRepository
     */
    protected $developerRepository;

    /**
     * DeveloperController constructor.
     * @param DeveloperRepository $developerRepository
     */
    public function __construct(DeveloperRepository $developerRepository)
    {
        $this->developerRepository = $developerRepository;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $developers = $this->developerRepository->getAll();
        $developerStatuses = developerStatuses();
        return view('dashboard.developers.index', compact('developers', 'developerStatuses'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {

        $developerPositions = developerPositions();
        $stacks = stacksForSelect2();

        return view('dashboard.developers.create', compact('developerPositions', 'stacks'));
    }


    /**
     * @param DeveloperRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(DeveloperRequest $request)
    {

        $this->developerRepository->store(Auth::id(), $request->validated());
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

        $developerPositions = developerPositions();

        $developerStatuses = developerStatuses();
        $stacks = stacksForSelect2();

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
        $this->putFlashMessage(true, 'Successfully updated');

        return redirect()->back();
    }


    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id)
    {

        $this->developerRepository->destroy($id);
        $this->putFlashMessage(true, 'Successfully deleted');
        return redirect()->route('developers.index');

    }

}
