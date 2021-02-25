<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * IndexController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function home()
    {
        return view('dashboard.index');

    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function profile()
    {
        return view('dashboard.account.profile');

    }

    /**
     * @param ProfileRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(ProfileRequest $request)
    {


        $data = $request->validated();

        if ($request->hasFile('avatar')) {

            $path =$request->file('avatar')->store('/public/avatars/' . Auth::id());
            $data['avatar'] = explode('public/',$path)[1];
        }

        $this->userRepository->update($data, Auth::id());

        $this->putFlashMessage(true);

        return redirect()->back();


    }
}
