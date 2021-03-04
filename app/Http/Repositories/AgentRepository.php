<?php

namespace App\Http\Repositories;

use App\Models\Agent;

class AgentRepository
{


    /**
     * @return Agent[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return Agent::all();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id)
    {
        return Agent::whereId($id)->first();

    }

    /**
     * @param array $requestData
     * @param int $creator_id
     */
    public function store(array $requestData, int $creator_id): void
    {
        $requestData['creator_id'] = $creator_id;
        Agent::create($requestData);
    }

    /**
     * @param array $requestData
     * @param int $id
     */
    public function update(array $requestData, int $id): void
    {

        $agent = $this->getById($id);

        if ($agent) {
            $agent->update($requestData);
        }

    }


    /**
     * @param int $id
     * @return array
     */
    public function destroy(int $id): array
    {

        $agent = $this->getById($id);

        if ($agent) {

            if ($agent->orders->count()) {

                return  ['msg'=>'Please before delete,delete orders where ID in array ['. implode(',', $agent->orders->pluck('id')->toArray()).']'];
            }

            $agent->delete();
        }

        return [];

    }

}
