<?php

namespace App\Linkedin\Responses;

use App\Linkedin\DTO\Message;
use App\Linkedin\Helper;
use Carbon\Carbon;
use Illuminate\Support\Collection;


class Messages
{
    const TYPE_KEY = '$type';
    const FROM_KEY = '*from';

    const MESSAGE_TYPE = 'com.linkedin.voyager.messaging.Event';

    /**
     * @var object
     */
    protected object $data;

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
     * @param string $conversation_urn
     */
    public function __construct(array $data, string $conversation_urn)
    {
        $this->data = collect($data['data']->included);

        $this->conversation_urn = $conversation_urn;
    }

    /**
     * @return array
     */
    public function initializ(): array
    {
        $messages = $this->data->filter(function ($item) {
            return $item->{self::TYPE_KEY} === self::MESSAGE_TYPE;
        });

        return $messages->map(function ($item) {
            return new Message([
                'text' => isset($item->eventContent) && isset($item->eventContent->attributedBody) ? $item->eventContent->attributedBody->text : '',
                'user_entityUrn' => Helper::searchInString($item->{self::FROM_KEY}, 'urn:li:fs_messagingMember:(' . $this->conversation_urn . ',', ')'),
                'entityUrn' => Helper::searchInString($item->entityUrn, 'urn:li:fs_event:(' . $this->conversation_urn . ',', ')'),
                'date' => Carbon::createFromTimestampMsUTC($item->createdAt)->toDateTimeString()
            ]);
        })->toArray();
    }
}
