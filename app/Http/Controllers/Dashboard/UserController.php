<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Repositories\RoleRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\UserInvitationRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{

    protected $userRepository;
    protected $roleRepository;

    /**
     * UserController constructor.
     * @param UserRepository $userRepository
     * @param RoleRepository $roleRepository
     */

    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {


        $roles = $this->roleRepository->getAll();

        $users = $this->userRepository->getAll();

        return view('dashboard.users.index', compact('roles', 'users'));

    }

    /**
     * @param UserInvitationRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */

    public function store(UserInvitationRequest $request)
    {

        $response = $this->userRepository->sendInvitationMail($request->validated());

        return response()->json($response, $response['status'] ?? 200);

    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function show($id,Request $request)
    {
        $user = $this->userRepository->getById($id);

        if (!$user) {
            abort(404);
        }

        $tab = 'timeline';

        if ($request->get('tab') && in_array($request->get('tab'), ['timeline', 'activities'])) {
            $tab = request()->get('tab');
        }

        $resource = $this->userRepository->$tab($user);

        return view('dashboard.users.show', compact('user', 'resource'));

    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $user = $this->userRepository->getById($id);

        if (!$user) {
            abort(404);
        }

        $roles = $this->roleRepository->getAll();

        return view('dashboard.users.edit', compact('user', 'roles'));

    }


    /**
     * @param UserRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function update(UserRequest $request, $id)
    {
        $this->userRepository->update($request->validated(), $id);
        $this->userRepository->syncRole($id, $request->get('role'));

        $this->putFlashMessage(true, 'successfully updated');

        return redirect()->back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->userRepository->destroy($id);
        $this->putFlashMessage(true, 'successfully deleted');

        return redirect()->back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resendInvitation($id)
    {

        $this->userRepository->resentInvitation($id);
        $this->putFlashMessage(true, 'successfully resend');
        return redirect()->back();
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login($id)
    {
        Auth::loginUsingId($id, true);
        $this->putFlashMessage(true, 'successfully');

        return redirect('/dashboard');
    }
}
