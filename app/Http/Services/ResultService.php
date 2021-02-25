<?php

namespace App\Http\Services;


use Illuminate\Contracts\Support\Arrayable;

class ResultService implements Arrayable
{
    private $status = false;
    private $result = null;

    /**
     * @return bool
     */
    public function getStatusResult(): bool
    {
        return $this->status;
    }

    /**
     * @param bool $status
     * @return $this
     */

    public function setStatusResult(bool $status): ResultService
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return null
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param null $result
     * @return ResultService
     */

    public function setResult($result)
    {
        $this->result = $result;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray() :array
    {
        return [
            'status' => $this->status,
            'result' => $this->result
        ];
    }


}
