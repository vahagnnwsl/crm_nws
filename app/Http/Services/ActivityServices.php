<?php

namespace App\Http\Services;

class ActivityServices
{

    /**
     * @param int $user_id
     * @param object $model
     * @param string $description
     * @param array $new_value
     * @param array $old_value
     */
    public function log(int $user_id, object $model, string $description,array $new_value, array $old_value)
    {

        activity()->performedOn($model)
            ->causedBy($user_id)
            ->withProperties(['attributes'=>['new' => $new_value,'old'=>$old_value]])
            ->log($description);
    }

}
