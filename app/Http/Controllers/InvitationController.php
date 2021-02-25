<?php

namespace App\Http\Controllers;

use App\Http\DTO\UserDto;
use App\Http\DTO\UserRequestDto;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\AcceptUserRequest;
use App\Http\Requests\UserInvitationRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;

class InvitationController extends Controller
{

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * InvitationController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('guest');
        $this->userRepository = $userRepository;
    }

    /**
     * @param $token
     * @param $email
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function acceptUserInvitationView($token, $email)
    {
        $user = $this->userRepository->getInvitationUserByEmailAndToke($token, $email);

        return view('invitation', compact('user'));
    }

    /**
     * @param AcceptUserRequest $request
     * @param $token
     * @param $email
     * @return \Illuminate\Http\RedirectResponse
     */

    public function acceptUserInvitation(AcceptUserRequest $request, $token, $email)
    {

        $data = $request->validated();

        $data['email'] = $email;
        $data['invitation_token'] = $token;


        $this->userRepository->acceptInvitationUser($data);


        $this->putFlashMessage(true, 'Successfully updated');
        return redirect()->route('login');

    }

}
