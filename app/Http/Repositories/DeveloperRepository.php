<?php

namespace App\Http\Repositories;

use App\Http\Services\ActivityServices;
use App\Models\Developer;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;

class DeveloperRepository
{

    const STATUS_INTERVIEWEES = 0;
    const STATUS_ACCEPTED = 1;
    const STATUS_REJECTED = 2;


    /**
     * @return mixed
     */
    public function getAll()
    {
        return Developer::orderByDesc('created_at')->paginate(20);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id)
    {
        return Developer::whereId($id)->first();
    }

    /**
     * @param int $creator_id
     * @param array $reqData
     */
    public function store(int $creator_id, array $reqData): void
    {
        $reqData['creator_id'] = $creator_id;

        if (isset($reqData['cv'])) {
            $reqData['cv'] = $this->uploadCv($reqData['cv']);
        }

        Developer::create($reqData);
    }

    /**
     * @param int $id
     * @param array $reqData
     */
    public function update(int $id, array $reqData): void
    {
        $developer = $this->getById($id);

        if ($developer) {
            if (isset($reqData['cv'])) {
                $reqData['cv'] = $this->uploadCv($reqData['cv']);
            }

            $developer->update($reqData);
        }
    }

    /**
     * @param object $cv
     * @return string
     */
    public function uploadCv(object $cv): string
    {
        $path = $cv->store('/public/cv');
        return explode('public/', $path)[1];
    }


    /**
     * @param int $id
     * @return array|string[]
     */
    public function destroy(int $id): array
    {
        $developer = $this->getById($id);

        if ($developer) {

            if ($developer->developerOrders->count()) {

                return  ['msg'=>'Please before delete,delete orders where ID in array ['. implode(',', $developer->developerOrders->pluck('id')->toArray()).']'];
            }

            if ($developer->teamLeadOrders->count()) {

                return  ['msg'=>'Please before delete,delete orders where ID in array ['. implode(',', $developer->teamLeadOrders->pluck('id')->toArray()).']'];
            }

            $developer->delete();
        }

        return  [];
    }

    /**
     * @return mixed
     */
    public function getAccepted()
    {
        return Developer::whereStatus($this::STATUS_ACCEPTED)->get();
    }

}
