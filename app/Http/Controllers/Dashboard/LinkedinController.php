<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Repositories\LinkedinConversationRepository;
use App\Http\Repositories\LinkedinMessageRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Resources\Collections\LinkedinMessageCollection;
use App\Http\Resources\LinkedinMessage;
use App\Linkedin\Responses\Response;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Linkedin\Api;
use Illuminate\Support\Facades\File;

class LinkedinController extends Controller
{


    /**
     * @var LinkedinMessageRepository
     */
    protected LinkedinMessageRepository $messageRepository;

    /**
     * @var LinkedinConversationRepository
     */
    protected LinkedinConversationRepository $conversationRepository;

    /**
     * @var UserRepository
     */
    protected UserRepository $userRepository;

    /**
     * LinkedinController constructor.
     * @param LinkedinMessageRepository $messageRepository
     * @param LinkedinConversationRepository $conversationRepository
     * @param UserRepository $userRepository
     */
    public function __construct(LinkedinMessageRepository $messageRepository, LinkedinConversationRepository $conversationRepository, UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->messageRepository = $messageRepository;
        $this->conversationRepository = $conversationRepository;
    }


    /**
     * @param Request $request
     * @return JsonResponse
     * @throws GuzzleException
     */
    public function storeMessage(Request $request): JsonResponse
    {

        $conversation = $this->conversationRepository->getById($request->get('conversation_id'));

        if ($conversation) {

            try {
                $resp = Response::storeMessage(Api::conversation(Auth::user()->linkedin_login, Auth::user()->linkedin_password)->writeMessage($request->get('text'), $conversation->entityUrn));

                $data = [
                    'conversation_id' => $conversation->id,
                    'conversation_entityUrn' => $conversation->entityUrn,
                    'user_entityUrn' => Auth::user()->linkedin_entityUrn,
                    'text' => $request->get('text'),
                    'status' => $this->messageRepository::DRAFT_STATUS,
                    'event' => $this->messageRepository::NOT_RECEIVE_EVENT,
                    'date' => Carbon::now()->toDateTimeString()
                ];

                if ($resp) {
                    $data['status'] = $this->messageRepository::SENDED_STATUS;
                    $data['entityUrn'] = $resp['entityUrn'];
                    $data['date'] = $resp['date'];
                }

                $message = $this->messageRepository->store($data);

                return response()->json(['message' => new LinkedinMessage($message)]);
            } catch (\Exception $exception) {
                return response()->json(['error' => $exception->getMessage()], $exception->getCode());
            }
        }

        return response()->json(['error' => 'Conversation not founded'], 411);
    }

    /**
     * @param int $conversation_id
     * @param int $message_id
     * @return JsonResponse
     * @throws GuzzleException
     */
    public function resendMessage(int $conversation_id, int $message_id): JsonResponse
    {
        $message = $this->messageRepository->getById($message_id);

        $conversation = $this->conversationRepository->getById($conversation_id);

        if ($message && $conversation) {

            if ($message->entityUrn && $message->status && $message->event) {
                return response()->json(['message' => new LinkedinMessage($message)]);
            }

            try {
                $resp = Response::storeMessage(Api::conversation(Auth::user()->linkedin_login, Auth::user()->linkedin_password)->writeMessage($message->text, $conversation->entityUrn));

                if ($resp) {

                    $this->messageRepository->update($resp, $message->id);

                    return response()->json([]);
                }
                return response()->json(['error' => 'Api error']);

            } catch (\Exception $exception) {
                return response()->json(['error' => $exception->getMessage()], $exception->getCode());
            }
        }

        return response()->json([]);
    }

    /**
     * @param int $conversation_id
     * @param int $user_id
     * @return JsonResponse
     */
    public function getConversationMessages(int $conversation_id, int $user_id): JsonResponse
    {
        $user = $this->userRepository->getById($user_id);

        if ($user) {
            return response()->json(['messages' => new LinkedinMessageCollection($this->messageRepository->getConversationMessagesForUser($conversation_id, $user->linkedin_entityUrn)->keyBy->hash)]);
        }

        return response()->json(['error' => 'User not founded'], 411);
    }

    /**
     * @param int $conversation_id
     * @return JsonResponse
     */
    public function syncConversationMessages(int $conversation_id): JsonResponse
    {
        $conversation = $this->conversationRepository->getById($conversation_id);

        try {

            $response = Response::messages((array)Api::conversation(Auth::user()->linkedin_login, Auth::user()->linkedin_password)->getConversationMessages($conversation->entityUrn), $conversation->entityUrn);
            $this->messageRepository->updateOrCreateCollection($response, $conversation_id, $conversation->entityUrn, $this->messageRepository::SENDED_STATUS, $this->messageRepository::RECEIVE_EVENT);
            return response()->json([]);

        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], $exception->getCode());
        }
    }

    /**
     * @return JsonResponse
     */
    public function syncConversations(): JsonResponse
    {

        try {
            $response = Api::conversation(Auth::user()->linkedin_login, Auth::user()->linkedin_password)->getConversations();

            if ($response['success']) {

                $this->conversationRepository->updateOrCreateCollection(Response::conversations($response, Auth::user()->linkedin_entityUrn), Auth::id());
                $this->putFlashMessage(true, 'Successfully synced');
                return response()->json([]);
            }

            return response()->json(['error' => 'Api error'], 411);

        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], $exception->getCode());
        }
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function searchProfile(Request $request): JsonResponse
    {
        try {
            $result = Response::profiles((array)Api::profile(Auth::user()->linkedin_login, Auth::user()->linkedin_password)->searchPeople($request->get('key'), ['network_depth' => 'O']));
            return response()->json(['profiles' => $result]);

        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 411);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function sendInvitation(Request $request): JsonResponse
    {
        return response()->json(Api::invitation(Auth::user()->linkedin_login, Auth::user()->linkedin_password)->sendInvitation($request->get('profile_id'), $request->get('tracking_id'), $request->get('message')));
    }

    /**
     * @return JsonResponse
     */
    public function getSentInvitations(): JsonResponse
    {
        return response()->json(['invitations' => Response::invitations((array)Api::invitation(Auth::user()->linkedin_login, Auth::user()->linkedin_password)->getSentInvitations())]);
    }

    /**
     * @return JsonResponse
     */
    public function getReceivedInvitations(): JsonResponse
    {
        return response()->json(['invitations' => Response::invitations((array)Api::invitation(Auth::user()->linkedin_login, Auth::user()->linkedin_password)->getReceivedInvitations(), true)]);
    }

    /**
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     * @throws GuzzleException
     */
    public function replyInvitation(Request $request, string $id): JsonResponse
    {
        $resp = Api::invitation(Auth::user()->linkedin_login, Auth::user()->linkedin_password)->replyInvitation($id, $request->get('sharedSecret'), $request->get('action'));

        return response()->json(['invitations' => $resp], $resp['status']);
    }

}
