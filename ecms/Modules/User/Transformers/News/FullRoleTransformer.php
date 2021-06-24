<?php

namespace Modules\User\Transformers\News;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\User\Permissions\PermissionManager;

class FullRoleTransformer extends JsonResource
{
    public function toArray($request)
    {
        $permissionsManager = app(PermissionManager::class);
        $permissions = $this->buildPermissionList($permissionsManager->all());

        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'created_at' => $this->created_at,
            'permissions' => $permissions,
            'users' => UserTransformer::collection($this->whenLoaded('users')),
            'urls' => [
                'delete_url' => route('api.user.role.destroy', $this->id??'0'),
            ],
        ];

        return $data;
    }

    private function buildPermissionList(array $permissionsConfig): array
    {
        $list = [];

        if ($permissionsConfig === null) {
            return $list;
        }

        foreach ($permissionsConfig as $mainKey => $subPermissions) {
            foreach ($subPermissions as $key => $permissionGroup) {
                foreach ($permissionGroup as $lastKey => $description) {
                    $list[strtolower($key) . '.' . $lastKey] = current_permission_value_for_roles($this, $key, $lastKey);
                }
            }
        }

        return $list;
    }
}
