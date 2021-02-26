<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Arr;


if (!function_exists('orderSources')) {

    /**
     * @return array
     */
    function orderSources(): array
    {
        return json_decode(File::get(resource_path('data/sources.json')))->order;
    }
}

if (!function_exists('stacks')) {

    /**
     * @return array
     */
    function stacks(): array
    {
        return (array)json_decode(File::get(resource_path('data/stacks.json')));
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
