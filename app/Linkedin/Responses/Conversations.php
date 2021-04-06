<?php

namespace App\Linkedin\Responses;

use App\Linkedin\DTO\Conversation as ConversationDTO;
use App\Linkedin\Helper;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class Conversations
{

    const TYPE_CONVERSATION = 'com.linkedin.voyager.messaging.Conversation';
    const TYPE_MESSAGING_MEMBER = 'com.linkedin.voyager.messaging.MessagingMember';
    const TYPE_MINI_PROFILE = 'com.linkedin.voyager.identity.shared.MiniProfile';

    const PARTICIPANTS_KEY = '*participants';

    const MESSAGING_MEMBER = 'com.linkedin.voyager.messaging.MessagingMember';
    const MINI_PROFILE = 'com.linkedin.voyager.identity.shared.MiniProfile';
    /**
     * @var object
     */
    protected object $data;

    /**
     * @var string
     */
    protected string $user_entityUrn;
    /**
     * @var Collection
     */
    protected Collection $elements;

    /**
     * Conversations constructor.
     * @param array $data
     * @param string $user_entityUrn
     */
    public function __construct(array $data, string $user_entityUrn)
    {
        $this->user_entityUrn = $user_entityUrn;
        $this->data = collect($data['data']->included);
    }

    /**
     * @return array
     */
    public function initializ(): array
    {

        $data = $this->data->groupBy('$type');

        $conversations = $data[self::TYPE_CONVERSATION]->filter(function ($conversation) {
            return !$conversation->groupChat;
        });


        $profiles = $data[self::TYPE_MINI_PROFILE]->map(function ($profile) {

            if (isset($profile->picture) && isset($profile->picture->artifacts) && count($profile->picture->artifacts) > 1) {
                $profile->picture = $profile->picture->rootUrl . $profile->picture->artifacts[1]->fileIdentifyingUrlPathSegment;
            }
            $profile->entityUrn = explode(':', $profile->entityUrn)[3];
            return collect($profile)->only('firstName', 'lastName', 'picture', 'entityUrn', 'publicIdentifier')->toArray();

        });

        $profiles = $profiles->filter(function ($item) {
            return $item['entityUrn'] !== 'UNKNOWN';
        });

        $array = [];

        foreach ($conversations as $conversation) {
            $entity_urn = explode(':', $conversation->entityUrn)[3];

            $members = [];

            $participant_urn = Helper::searchInString($conversation->{self::PARTICIPANTS_KEY}[0], 'urn:li:fs_messagingMember:(' . $entity_urn . ',', ')');

            $user = $profiles->first(function ($profile)  {
                return $profile['entityUrn'] === $this->user_entityUrn;
            });

            array_push($members,$user);

            $member = $profiles->first(function ($profile) use ($participant_urn) {
                return $profile['entityUrn'] === $participant_urn;
            });

            $conversation->entityUrn = $entity_urn;
            $conversation->lastActivityAt = Carbon::createFromTimestampMsUTC($conversation->lastActivityAt)->toDateTimeString();

            if ($member) {
                array_push($members,$member);

                $conversation->data = ['member' => $members];
                array_push($array, new ConversationDTO((array)$conversation));
            }

        }

        return $array;
    }
}
