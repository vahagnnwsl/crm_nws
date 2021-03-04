<?php

namespace App\Http\Repositories;

use App\Http\Services\ActivityServices;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;

class RoleRepository
{

    /**
     * @var ActivityServices
     */
    protected $logger;

    /**
     * RoleRepository constructor.
     */
    public function __construct()
    {
        $this->logger = new ActivityServices();
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        return Role::orderByDesc('created_at')->get();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id)
    {
        return Role::whereId($id)->first();
    }

    /**
     * @param int $id
     * @param array $permissions
     * @param int|false $user_id
     */
    public function syncPermissions(int $id, array $permissions, $user_id = false): void
    {
        $role = $this->getById($id);

        if (!$user_id) {
            $user_id = Auth::id();
        }

        if ($role) {
           // $this->logger->log($user_id,$role,'Synced permissions',$permissions,$role->permissions->pluck('id')->toArray());
            $role->syncPermissions($permissions);
        }


    }

    /**
     * @param array $data
     */
    public function store(array $data): void
    {
        $data['guard_name'] = 'web';
        Role::create($data);
    }

}
