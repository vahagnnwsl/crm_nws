<?php

namespace App\Http\Repositories;

use App\Http\Services\ActivityServices;
use App\Models\Developer;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;

class DeveloperRepository extends Repository
{

    const STATUS_INTERVIEWEES = 0;
    const STATUS_ACCEPTED = 1;
    const STATUS_REJECTED = 2;


    /**
     * @return string
     */
    public function model()
    {
        return Developer::class;
    }

    /**
     * @param array $requestData
     * @return mixed
     */
    public function getAll(array $requestData)
    {
        return $this->filter($requestData);
    }


    /**
     * @param int $creator_id
     * @param array $reqData
     * @return mixed
     */
    public function store(int $creator_id, array $reqData)
    {
        $reqData['creator_id'] = $creator_id;

        if (isset($reqData['cv'])) {
            $reqData['cv'] = $this->upload($reqData['cv'], 'cv');
        }

        if (isset($reqData['avatar'])) {
            $reqData['avatar'] = $this->upload($reqData['avatar'], 'developer_avatars');
        }

        return $this->create($reqData);

    }

    /**
     * @param int $id
     * @param array $reqData
     */
    public function update(int $id, array $reqData): void
    {
        if (isset($reqData['cv'])) {
            $reqData['cv'] = $this->upload($reqData['cv'], 'cv');
        }

        if (isset($reqData['avatar'])) {
            $reqData['avatar'] = $this->upload($reqData['avatar'], 'developer_avatars');
        }


        $this->edit($id, $reqData);
    }

    /**
     * @param int $id
     * @return array|string[]
     */
    public function destroy(int $id): array
    {
        return $this->delete($id);
    }

    /**
     * @return mixed
     */
    public function getAccepted()
    {
        return $this->model()::whereStatus($this::STATUS_ACCEPTED)->get();
    }

    /**
     * @param int $id
     * @param array $stacks
     */
    public function syncStacks(int $id, array $stacks): void
    {
        $this->setStacks($id, $stacks);
    }

    /**
     * @param array $requestData
     * @param int $developer_id
     * @param int $creator_id
     */
    public function storeInterview(array $requestData, int $developer_id, int $creator_id): void
    {
        $developer = $this->getById($developer_id);

        $requestData['creator_id'] = $creator_id;

        $developer->interviews()->create($requestData);
    }


    /**
     * @param int $developer_id
     * @param int $interview_id
     */
    public function deleteInterview(int $developer_id, int $interview_id): void
    {
        $developer = $this->getById($developer_id);

        $developer->interviews()->whereId($interview_id)->delete();
    }
}
