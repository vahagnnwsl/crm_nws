<?php

namespace App\Linkedin\Responses;

use App\Linkedin\Constants;
use App\Linkedin\DTO\Message;
use App\Linkedin\DTO\Profile;
use App\Linkedin\Helper;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;


class Profiles
{
    const TYPE_KEY = '$type';
    const FROM_KEY = '*from';

    const TYPE_MINI_PROFILE = 'com.linkedin.voyager.identity.shared.MiniProfile';
    const TYPE_MEMBER_BADGES = 'com.linkedin.voyager.identity.profile.MemberBadges';
    const TYPE_BLENDED_SEARCH_CLUSTER = 'com.linkedin.voyager.search.BlendedSearchCluster';

    /**
     * @var object
     */
    protected $data;

    /**
     * @var Collection
     */
    protected Collection $elements;

    /**
     * @var string
     */
    protected string $conversation_urn;

    /**
     * Messages constructor.
     * @param array $data
     *
     */
    public function __construct(array $data)
    {
        //File::put(storage_path('b.json'), json_encode($data));

        $this->data = $data['data'];
    }

    /**
     * @return array
     */
    public function initializ(): array
    {
        $profiles = $this->data->included;

        $profiles = collect($profiles)->groupBy('$type');

        if (!isset($profiles[self::TYPE_MINI_PROFILE])) {
            return [];
        }

        $profiles = $profiles[self::TYPE_MINI_PROFILE];

        $profiles = $profiles->map(function ($profile) {

            $profile->fullName = $profile->firstName . ' ' . $profile->lastName;
            if (isset($profile->picture) && isset($profile->picture->artifacts) && count($profile->picture->artifacts) > 1) {
                $profile->picture = $profile->picture->rootUrl . $profile->picture->artifacts[1]->fileIdentifyingUrlPathSegment;
            }

            $profile->entityUrn = explode(':', $profile->entityUrn)[3];
            return new Profile((array)$profile);
        })->toArray();

        $elements = $this->data->data->elements;

        $filteredElements = [];

        foreach ($elements as $element) {

            if ($element->{self::TYPE_KEY} === self::TYPE_BLENDED_SEARCH_CLUSTER) {

                if (isset($element->elements) && count($element->elements)) {
                    array_push($filteredElements, ...$element->elements);

                }
            }
        }

        return collect($filteredElements)->map(function ($item) use ($profiles) {

            $entityUrn = explode(':', $item->targetUrn)[3];
            $item->fullName = $item->title->text;
            if (isset( $item->headline)){
                $item->headline = $item->headline->text;
            }

            if (isset($item->secondaryTitle)) {
                $item->secondaryTitle = $item->secondaryTitle->text;
            }
            $item->entityUrn = $entityUrn;
            $item->picture = collect($profiles)->first(function ($profile) use ($entityUrn) {
                    return $profile->entityUrn === $entityUrn;
                })->picture ?? Constants::DEFAULT_AVATAR;

            return new Profile((array)$item);
        })->toArray();

    }
}
