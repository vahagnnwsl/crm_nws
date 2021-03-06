<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Activity extends Component
{


    protected $resource;


    public function __construct($resource)
    {
        $this->resource = $resource;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $resource = $this->resource;


        return view('components.activity',compact('resource'));
    }
}
