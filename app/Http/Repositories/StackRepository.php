<?php

namespace App\Http\Repositories;

use App\Models\Stack;

class StackRepository
{

    /**
     * @return mixed
     */
    public function getAll()
    {
        return Stack::all();
    }

    /**
     * @param string $field
     * @return mixed
     */
    public function pluckFiled(string $field)
    {
        return Stack::pluck($field)->toArray();
    }

    /**
     * @param array $ides
     * @return mixed
     */
    public function getByIdes(array $ides)
    {
        return Stack::whereIn('id', $ides)->get();
    }
}
