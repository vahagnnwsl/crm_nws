<?php

namespace App\Http\Repositories;

use App\Models\User;
use App\Notifications\UserInvitationNotification;
use Illuminate\Support\Facades\Storage;


class UserRepository
{


    const INACTIVE_STATUS = 0;
    const ACTIVE_STATUS = 1;

    /**
     * @param array $requestData
     * @return array
     */
    public function sendInvitationMail(array $requestData): array
    {


        if ($user = $this->getActiveUserByEmail($requestData['email'])) {

            return [
                'errors' => [
                    'email' => [
                        'User already exist'
                    ]
                ],
                'status' => 411
            ];
        }


        if ($user = $this->getInvitationUserByEmail($requestData['email'])) {
            $user->update([
                'invitation_token' => $this->generateInvitationToken($requestData['email'])
            ]);
        } else {
            $requestData['invitation_token'] = $this->generateInvitationToken($requestData['email']);
            $requestData['status'] = self::INACTIVE_STATUS;
            $user = User::create($requestData);
            $this->syncRole($user->id, $requestData['role']);
        }


        $user->notify(new UserInvitationNotification());


        return [];

    }

    /**
     * @param string $email
     * @return mixed
     */
    public function getActiveUserByEmail(string $email)
    {
        return User::whereEmail($email)->whereStatus(1)->whereNull('invitation_token')->first();
    }

    /**
     * @param string $email
     * @return mixed
     */
    public function getInvitationUserByEmail(string $email)
    {
        return User::whereEmail($email)->whereStatus(0)->whereNotNull('invitation_token')->first();
    }

    public function getInvitationUserByEmailAndToke(string $token, string $email)
    {
        return User::whereEmail($email)->whereStatus(0)->whereInvitationToken($token)->first();
    }


    /**
     * @param array $requestData
     * @param int $id
     */
    public function update(array $requestData, int $id): void
    {

        $user = $this->getById($id);

        if ($user) {
            $user->update($requestData);
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return User::whereId($id)->first();
    }

    /**
     * @param $requestData
     */

    public function acceptInvitationUser($requestData): void
    {

        $user = $this->getInvitationUserByEmailAndToke($requestData['invitation_token'], $requestData['email']);

        if ($user) {
            $requestData['password'] = bcrypt($requestData['password']);
            $requestData['status'] = self::ACTIVE_STATUS;
            $requestData['invitation_token'] = '';
            $user->update($requestData);
        }
    }

    /**
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getAll()
    {
        return User::with('roles')->paginate(20);
    }

    /**
     * @param int $user_id
     * @param int $role_id
     */
    public function syncRole(int $user_id, int $role_id): void
    {
        $user = $this->getById($user_id);
        if ($user) {
            $user->syncRoles($role_id);
        }

    }

    /**
     * @param $id
     * @return array
     */

    public function destroy($id): array
    {
        $user = $this->getById($id);

        if ($user) {

            if ($user->orders->count()) {
                return [
                    'msg' => 'Please before delete,delete orders where ID in array [' . implode(',', $user->orders->pluck('id')->toArray()) . ']'
                ];
            }

            if ($user->orders->agents()) {
                return [
                    'msg' => 'Please before delete,delete agents where ID in array [' . implode(',', $user->agents->pluck('id')->toArray()) . ']'
                ];
            }

            if ($user->orders->developers()) {
                return [
                    'msg' => 'Please before delete,delete developers where ID in array [' . implode(',', $user->developers->pluck('id')->toArray()) . ']'
                ];
            }

            if ($user->orders->orderPersons()) {
                return [
                    'msg' => 'Please before delete,delete orderPersons where ID in array [' . implode(',', $user->orderPersons->pluck('id')->toArray()) . ']'
                ];
            }

            $user->delete();
        }

        return [];
    }

    /**
     * @param string $email
     * @return string
     */
    public function generateInvitationToken(string $email): string
    {
        return md5($email . time());
    }

    /**
     * @param int $id
     */
    public function resentInvitation(int $id): void
    {
        $user = $this->getById($id);

        if ($user) {
            $this->sendInvitationMail(['email' => $user->email]);
        }

    }

    /**
     * @param object $user
     * @return mixed
     */
    public function activities(object $user)
    {
        $activities = $user->activities()->orderByDesc('created_at')->paginate(10);


        $grouped_by_date = $activities->mapToGroups(function ($activity) {
            return [$activity->created_at->format('Y-m-d') => $activity];

        });

        return $activities->setCollection($grouped_by_date);
    }

    /**
     * @param object $user
     * @return mixed
     */

    public function timeline(object $user)
    {
        $timeline = $user->timeline()->orderByDesc('created_at')->paginate(10);


        $grouped_by_date = $timeline->mapToGroups(function ($item) {
            return [$item->created_at->format('Y-m-d') => $item];

        });

        return $timeline->setCollection($grouped_by_date);
    }

    /**
     * @return User[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return User::all();
    }

    /**
     * @return mixed
     */
    public function getAllWithOrdersCount()
    {
        return User::withCount('orders')->get();
    }
}
