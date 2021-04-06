<?php

namespace App\Http\Controllers\Api;

use App\Events\NewMessage;
use App\Events\SyncConversations;
use App\Http\Controllers\Controller;
use App\Http\Repositories\LinkedinConversationRepository;
use App\Http\Repositories\LinkedinMessageRepository;
use App\Http\Resources\LinkedinMessage;
use App\Linkedin\Responses\Response;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Linkedin\Api;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

class ConversationController extends Controller
{

    /**
     * @var LinkedinConversationRepository
     */
    public LinkedinConversationRepository $conversationRepository;

    /**
     * @var LinkedinMessageRepository
     */
    public LinkedinMessageRepository $messageRepository;

    /**
     * ConversationController constructor.
     * @param LinkedinConversationRepository $conversationRepository
     * @param LinkedinMessageRepository $messageRepository
     */
    public function __construct(LinkedinConversationRepository $conversationRepository, LinkedinMessageRepository $messageRepository)
    {
        $this->conversationRepository = $conversationRepository;
        $this->messageRepository = $messageRepository;
    }

    /**
     * @param string $entityUrn
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function store(string $entityUrn, Request $request): \Illuminate\Http\JsonResponse
    {
        $conversation = $this->conversationRepository->getByEntityUrn($entityUrn);
        $data = $request->all();

        $user = User::where('linkedin_login',$data['user_login'])->first();

        if ($conversation) {

            $data['date'] = Carbon::createFromTimestampMsUTC($data['date'])->toDateTimeString();

            $login = $data['user_login'];
            $data = Arr::except($data, 'user_login');
            $data['conversation_id'] = $conversation->id;
            $data['status'] = $this->messageRepository::SENDED_STATUS;
            $data['event'] = $this->messageRepository::RECEIVE_EVENT;

            $message = $this->messageRepository->updateOrCreate($data);



            foreach ($conversation->users as $user) {
                try {
                    event(new NewMessage((new LinkedinMessage($message))->toArray([]), $user->linkedin_entityUrn));
                }catch (\Exception $exception){
                    return response()->json(['success' => $exception->getMessage()]);

                }
            }
            return response()->json(['success' => true]);


        }else{

            $response = Api::conversation($user->linkedin_login, $user->linkedin_password)->getConversations();

            if ($response['success']) {

                $this->conversationRepository->updateOrCreateCollection(Response::conversations($response, $user->linkedin_entityUrn), $user->id);

                $response = Response::messages((array)Api::conversation($user->linkedin_login, $user->linkedin_password)->getConversationMessages($entityUrn), $entityUrn);

                $conversation = $this->conversationRepository->getByEntityUrn($entityUrn);

                $this->messageRepository->updateOrCreateCollection($response, $conversation->id, $conversation->entityUrn, $this->messageRepository::SENDED_STATUS, $this->messageRepository::RECEIVE_EVENT);

                event(new SyncConversations($user->linkedin_entityUrn));

                return response()->json(['data' => 'New conversation']);

            }

            return response()->json(['data' => 'Something wrong']);
        }

    }
}
