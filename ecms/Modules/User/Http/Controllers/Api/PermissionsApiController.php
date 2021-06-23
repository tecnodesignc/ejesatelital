<?php

namespace Modules\User\Http\Controllers\Api;

use Modules\Core\Http\Controllers\Api\BaseApiController;
use Modules\User\Permissions\PermissionManager;
use Modules\User\Permissions\PermissionsRemover;

class PermissionsApiController extends BaseApiController
{
    /**
     * @var PermissionManager
     */
    private $permissionManager;


    public function __construct(PermissionManager $permissionManager)
    {
        $this->permissionManager = $permissionManager;
    }

    public function index()
    {
        dd($this->permissionManager->all());

        return response()->json([
            'permissions' => $this->permissionManager->all(),
        ]);
    }
}
