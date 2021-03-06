<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Arr;
use App\Http\Repositories\DeveloperRepository;
use App\Http\Repositories\OrderRepository;


if (!function_exists('orderSources')) {

    /**
     * @return array
     */
    function orderSources(): array
    {

        return json_decode(File::get(resource_path('data/settings.json')))->orderSources;
    }
}

if (!function_exists('stacks')) {

    /**
     * @return array
     */
    function stacks(): array
    {

        return (array)json_decode(File::get(resource_path('data/settings.json')))->stacks;
    }
}


if (!function_exists('stacksForSelect2')) {

    /**
     * @return array
     */

    function stacksForSelect2(): array
    {
        $stacks = [];

        foreach (stacks() as $key => $stack) {
            array_push($stacks, [
                'text' => $key,
                'children' => collect($stack)->map(function ($item) {
                    return [
                        'id' => $item,
                        'text' => $item
                    ];
                })
            ]);
        }

        return $stacks;
    }
}


if (!function_exists('stacksList')) {

    /**
     * @return array
     */

    function stacksList(): array
    {
        return Arr::collapse(stacks());
    }
}

if (!function_exists('currencies')) {

    /**
     * @return array
     */

    function currencies(): array
    {
        return (array)json_decode(File::get(resource_path('data/settings.json')))->currencies;

    }
}


if (!function_exists('currenciesList')) {

    /**
     * @return array
     */

    function currenciesList(): array
    {
        return Arr::pluck(currencies(), 'label');
    }
}

if (!function_exists('developerPositions')) {

    /**
     * @return array
     */

    function developerPositions(): array
    {
        return (array)json_decode(File::get(resource_path('data/settings.json')))->developer_positions;
    }
}

if (!function_exists('developerStatuses')) {

    /**
     * @return array
     */
    function developerStatuses(): array
    {

        return [
            DeveloperRepository::STATUS_INTERVIEWEES => 'INTERVIEWEES',
            DeveloperRepository::STATUS_ACCEPTED => 'ACCEPTED',
            DeveloperRepository::STATUS_REJECTED => 'REJECTED'
        ];
    }
}

if (!function_exists('orderStatuses')) {

    /**
     * @return array
     */
    function orderStatuses(): array
    {

        return [
            OrderRepository::STATUS_SANDED => 'SANDED',
            OrderRepository::STATUS_PENDING => 'PENDING',
            OrderRepository::STATUS_INTERVIEW => 'INTERVIEW',
            OrderRepository::STATUS_COMPLETE_FORM => 'COMPLETE_FORM',
            OrderRepository::STATUS_CODE_EXAMPLE => 'CODE_EXAMPLE',
            OrderRepository::STATUS_TEST_TASK => 'TEST_TASK',
            OrderRepository::STATUS_CONVERSATION => 'CONVERSATION',
            OrderRepository::STATUS_NOT_REMOTE => 'NOT_REMOTE',
            OrderRepository::STATUS_DECLINE => 'DECLINE',
            OrderRepository::STATUS_FIRST_CALL => 'FIRST_CALL',
            OrderRepository::STATUS_SECOND_CALL => 'SECOND_CALL',
            OrderRepository::STATUS_OFFER => 'OFFER',

        ];
    }
}

if (!function_exists('collectionToArrayForFilter')) {
    /**
     * @param $collction
     * @return string[]
     */
    function collectionToArrayForFilter($collction): array
    {

        $array = [];

        foreach ($collction as $item) {
            $array[$item->id] = $item->fullName;
        }

        return $array;
    }
}


