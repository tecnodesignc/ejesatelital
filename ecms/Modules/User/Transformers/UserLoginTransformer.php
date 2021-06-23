<?php

namespace Modules\User\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\User\Permissions\PermissionManager;

class UserLoginTransformer extends JsonResource
{
    public function toArray($request)
    {
        $permissionsManager = app(PermissionManager::class);
        $permissions =$permissionsManager->buildPermissionList();
        $data = [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'is_activated' => $this->isActivated(),
            'last_login' => $this->last_login,
            'created_at' => $this->created_at,
            'permissions' => $permissions,
            'roles' => $this->roles->pluck('id'),

            'urls' => [
                'logout' => route('api.user.logout'),
            ],
        ];
        return $data;
    }
}
