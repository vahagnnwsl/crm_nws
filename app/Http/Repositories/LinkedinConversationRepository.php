<?php

namespace App\Http\Repositories;

use App\Models\LinkedinConversation;

class LinkedinConversationRepository extends Repository
{

    /**
     * @return string
     */
    public function model(): string
    {
        return LinkedinConversation::class;
    }


    /**
     * @param array $requestData
     * @return mixed
     */
    public function updateOrCreate(array $requestData)
    {
        return $this->model()::updateOrCreate([
            'entityUrn' => $requestData['entityUrn']
        ], $requestData);
    }


    /**
     * @param string $entityUrn
     * @return mixed
     */
    public function getByEntityUrn(string $entityUrn)
    {
        return $this->model()::where('entityUrn', $entityUrn)->first();
    }


    /**
     * @param int $id
     */
    public function updateLastActivityAt(int $id): void
    {
        $conversation = $this->getById($id);
        $conversation->update(['lastActivityAt' => date('Y-m-d H:m:s')]);
    }

    /**
     * @param array $requestData
     * @param int $user_id
     */
    public function updateOrCreateCollection(array $requestData,int $user_id): void
    {
        foreach ($requestData as $data) {
            $data = $data->getAttributes();
           $conversation =  $this->model()::updateOrCreate([
                'entityUrn' => $data['entityUrn']
            ], $data);

           $conversation->users()->detach($user_id);
           $conversation->users()->attach($user_id);
        }
    }
}
