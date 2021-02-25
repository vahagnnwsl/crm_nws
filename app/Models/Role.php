<?php

namespace App\Models;

use Spatie\Activitylog\Traits\LogsActivity;

class Role extends \Spatie\Permission\Models\Role
{

    use LogsActivity;


    /**
     * @var string[]
     */
    protected static $logAttributes = ['name', 'icon'];

    /**
     * @return string
     */
    public function getNameForLogAttribute()
    {
        return "Role {$this->name}";
    }
}
