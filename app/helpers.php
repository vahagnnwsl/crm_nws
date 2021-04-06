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
            OrderRepository::STATUS_ONGOING => 'ONGOING',

        ];
    }
}

if (!function_exists('orderColors')) {

    /**
     * @return array
     */
    function orderColors(): array
    {

        return OrderRepository::$COLORS;
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
            $array[$item->id] = $item->fullName ?? $item->name;
        }

        return $array;
    }
}

if (!function_exists('toAssoc')) {
    /**
     * @param array $array
     * @return array
     */
    function toAssoc(array $array): array
    {

        $newArray = [];

        foreach ($array as $item) {
            $newArray[$item] = $item;
        }

        return $newArray;
    }
}

if (!function_exists('collectionConvertForSelect2')) {

    /**
     * @param object $collection
     * @return array
     */
    function collectionConvertForSelect2(object $collection): array
    {

        $array = [];

        foreach ($collection as $item) {
            array_push($array, [
                'id' => $item->id,
                'text' => $item->name ?? $item->fullName
            ]);
        }

        return $array;
    }
}

if (!function_exists('arrayConvertForSelect2')) {

    /**
     * @param array $array
     * @param false $t
     * @return array
     */
    function arrayConvertForSelect2(array $array, $t = false): array
    {

        $newArray = [];

        foreach ($array as $key => $item) {
            array_push($newArray, [
                'id' => $t ? $key : $item,
                'text' => $item
            ]);
        }

        return $newArray;
    }
}

if (!function_exists('getOldStacksForSelect2')) {

    /**
     * @param array $array
     * @return array
     */
    function getOldStacksForSelect2(array $array): array
    {
        if (count($array)) {
            return collectionConvertForSelect2((new \App\Http\Repositories\StackRepository())->getByIdes($array));
        }

        return [];
    }
}


