<?php

namespace App\Http\Repositories;

use App\Models\LinkedinMessage;
use Carbon\Carbon;

class LinkedinMessageRepository extends Repository
{

    const DRAFT_STATUS = 0;
    const SENDED_STATUS = 1;

    const NOT_RECEIVE_EVENT = 0;
    const RECEIVE_EVENT = 1;

    /**
     * @return string
     */
    public function model(): string
    {
        return LinkedinMessage::class;
    }

    /**
     * @param array $requestData
     * @return mixed
     */
    public function store(array $requestData)
    {
        return $this->create($requestData);
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
     * @param array $requestData
     * @param int $conversation_id
     * @param string $conversation_entityUrn
     * @param int $status
     * @param int $event
     */
    public function updateOrCreateCollection(array $requestData, int $conversation_id, string $conversation_entityUrn, int $status = self::DRAFT_STATUS,int $event = self::NOT_RECEIVE_EVENT): void
    {
        foreach ($requestData as $data) {

            $data = $data->getAttributes();
            $data['conversation_id'] = $conversation_id;
            $data['conversation_entityUrn'] = $conversation_entityUrn;
            $data['status'] = $status;
            $data['event'] = $event;

            $this->model()::updateOrCreate([
                'entityUrn' => $data['entityUrn']
            ], $data);
        }
    }

    /**
     * @param int $conversation_id
     * @param string $user_entityUrn
     * @return mixed
     */
    public function getConversationMessagesForUser(int $conversation_id, string $user_entityUrn)
    {
        return $this->model()::whereConversationId($conversation_id)->where(function ($q) use ($user_entityUrn) {

            return $q->where('status', self::SENDED_STATUS)->orWhere(['status' => self::DRAFT_STATUS, 'user_entityUrn' => 'ACoAACKvpZ0B_D57F3IJRPfyBnZoFsshG69_rrg']);

        })->orderBy('date')->get();

    }

    /**
     * @param array $requestData
     * @param int $id
     */
    public function update(array $requestData, int $id): void
    {
        $this->edit($id, $requestData);
    }

}
