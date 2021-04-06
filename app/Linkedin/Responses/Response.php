<?php

namespace App\Linkedin\Responses;

use App\Linkedin\Constants;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class Response
{

    const TYPE_MINI_PROFILE = 'com.linkedin.voyager.identity.shared.MiniProfile';

    /**
     * @param array $data
     * @param string $user_entityUrn
     * @return array
     */
    public static function conversations(array $data, string $user_entityUrn): array
    {
        if ($data['success'] && isset($data['data'])) {
            return (new Conversations($data, $user_entityUrn))->initializ();
        }
        return [];
    }

    /**
     * @param array $data
     * @param string $conversation_urn
     * @return array
     */
    public static function messages(array $data, string $conversation_urn): array
    {

        if ($data['success'] && isset($data['data'])) {
            return (new Messages($data, $conversation_urn))->initializ();
        }
        return [];
    }

    /**\
     * @param array $data
     * @return array
     */
    public static function storeMessage(array $data): array
    {
        if ($data['success'] && isset($data['data'])) {
            return [
                'entityUrn' => explode(':', $data['data']->data->value->backendEventUrn)[3],
                'date' => Carbon::createFromTimestampMsUTC($data['data']->data->value->createdAt)->toDateTimeString()
            ];
        }
        return [];
    }

    /**\
     * @param array $data
     * @return array
     */
    public static function profiles(array $data): array
    {

        if ($data['success'] && isset($data['data'])) {
            return (new Profiles($data))->initializ();

        }
        return [];
    }

    public static function invitations(array $data,bool $con = false): array
    {


        if (!$data['success'] || !isset($data['data']) || !count($data['data']->included)) {
            return [];
        }

        $invitation_type_key = 'com.linkedin.voyager.relationships.invitation.Invitation';

        $included = collect($data['data']->included)->groupBy('$type');

        return $included[$invitation_type_key]->map(function ($item) use ($con, $included) {

            $profile = $included[self::TYPE_MINI_PROFILE]->first(function ($profile) use ($item,$con) {
                if ($con){
                    return $item->{'*fromMember'} === $profile->entityUrn;

                }else{
                    return $item->invitee->{'*miniProfile'} === $profile->entityUrn;
                }
            });

            $avatar = null;
            if (isset($profile->picture) && isset($profile->picture->artifacts) && count($profile->picture->artifacts) > 1) {
                $avatar = $profile->picture->rootUrl . $profile->picture->artifacts[1]->fileIdentifyingUrlPathSegment;
            }

            return [
                'profile' => [
                    'fullName' => $profile->firstName . ' ' . $profile->lastName,
                    'avatar' => $avatar ?? Constants::DEFAULT_AVATAR,
                    'occupation' => $profile->occupation
                ],
                'sharedSecret' => $item->sharedSecret,
                'entityUrn' => explode(':', $item->entityUrn)[3],
                'sentTime' => Carbon::createFromTimestampMsUTC($item->sentTime)->toDateTimeString()
            ];
        })->toArray();
    }
}
