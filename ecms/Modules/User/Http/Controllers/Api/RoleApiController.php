<?php

namespace Modules\User\Http\Controllers\Api;

use Cartalyst\Sentinel\Roles\EloquentRole;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Http\Requests\CreateRoleRequest;
use Modules\User\Http\Requests\UpdateRoleRequest;
use Modules\User\Permissions\PermissionManager;
use Modules\User\Repositories\RoleRepository;
use Modules\User\Transformers\FullRoleTransformer;
use Modules\User\Transformers\News\RoleTransformer;

class RoleApiController extends Controller
{
    /**
     * @var RoleRepository
     */
    private $role;
    /**
     * @var PermissionManager
     */
    private $permissions;

    public function __construct(RoleRepository $role, PermissionManager $permissions)
    {
        $this->role = $role;
        $this->permissions = $permissions;
    }



    /**
     * GET ITEMS
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        try {
            //Validate permissions
            $this->validatePermission($request, 'user.roles.index');
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $roles = $this->role->getItemsBy($params);

            //Response
            $response = [
                "data" => RoleTransformer::collection($roles)
            ];

            //If request pagination add meta-page
            $params->page ? $response["meta"] = ["page" => $this->pageTransformer($roles)] : false;
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }

    /**
     * GET A ITEM
     *
     * @param $criteria
     * @return mixed
     */
    public function show($criteria, Request $request)
    {
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $role = $this->role->getItem($criteria, $params);

            //Break if no found item
            if (!$role) throw new \Exception('Item not found', 404);

            //Response
            $response = ["data" => new RoleTransformer($role)];

            //If request pagination add meta-page
            $params->page ? $response["meta"] = ["page" => $this->pageTransformer($role)] : false;
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }

    /**
     * UPDATE ITEM
     *
     * @param $criteria
     * @param Request $request
     * @return mixed
     */
    public function update($criteria, Request $request)
    {
        \DB::beginTransaction(); //DB Transaction
        try {
            //Validate Permission
            $this->validatePermission($request, 'profile.role.edit');

            //Get data
            $data = $request->input('attributes');

            //Validate Request
            $this->validateRequestApi(new UpdateRoleApiRequest((array)$data));

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $role = $this->role->updateBy($criteria, $data, $params);

            //Create or Update Settings
            if (isset($data["settings"]))
                foreach ($data["settings"] as $settingName => $setting) {
                    $this->profileSetting->updateOrCreate(
                        ['related_id' => $role->id, 'entity_name' => 'role', 'name' => $settingName],
                        ['related_id' => $role->id, 'entity_name' => 'role', 'name' => $settingName, 'value' => $setting]
                    );
                }

            //Response
            $response = ['data' => ''];
            \DB::commit();//Commit to DataBase
        } catch (\Exception $e) {
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }

    /**
     * CREATE A ITEM
     *
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        \DB::beginTransaction();
        try {
            //Validate Permission
            $this->validatePermission($request, 'profile.role.create');

            //Get data
            $data = $request->input('attributes');

            //Validate Request
            $this->validateRequestApi(new CreateRoleApiRequest((array)$data));

            //Create item
            $role = $this->role->create($data);

            //Create or Update Settings
            if (isset($data["settings"]))
                foreach ($data["settings"] as $settingName => $setting) {
                    $this->validateResponseApi(
                        $this->setting->create(new Request(['attributes' =>
                            ['related_id' => $role->id, 'entity_name' => 'role', 'name' => $settingName, 'value' => $setting]
                        ]))
                    );
                }

            //Response
            $response = ["data" => ""];
            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }
        //Return response
        return response()->json($response, $status ?? 200);
    }

    /**
     * DELETE A ITEM
     *
     * @param $criteria
     * @return mixed
     */
    public function delete($criteria, Request $request)
    {
        \DB::beginTransaction();
        try {
            //Validate Permission
            $this->validatePermission($request, 'profile.role.destroy');

            //Get params
            $params = $this->getParamsRequest($request);

            //call Method delete
            $this->role->deleteBy($criteria, $params);

            //Response
            $response = ["data" => ""];
            \DB::commit();//Commit to Data Base
        } catch (\Exception $e) {
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }


    public function all()
    {
        return RoleTransformer::collection($this->role->all());
    }



    public function find(EloquentRole $role)
    {
        return new FullRoleTransformer($role->load('users'));
    }

    public function findNew(EloquentRole $role)
    {
        return new FullRoleTransformer($role);
    }

    public function store(CreateRoleRequest $request)
    {
        $data = $this->mergeRequestWithPermissions($request);

        $this->role->create($data);

        return response()->json([
            'errors' => false,
            'message' => trans('user::messages.role created'),
        ]);
    }

    public function update8(EloquentRole $role, UpdateRoleRequest $request)
    {
        $data = $this->mergeRequestWithPermissions($request);

        $this->role->update($role->id, $data);

        return response()->json([
            'errors' => false,
            'message' => trans('user::messages.role updated'),
        ]);
    }

    public function destroy(EloquentRole $role)
    {
        $this->role->delete($role->id);

        return response()->json([
            'errors' => false,
            'message' => trans('user::messages.role deleted'),
        ]);
    }

    /**
     * @param Request $request
     * @return array
     */
    private function mergeRequestWithPermissions(Request $request)
    {
        $permissions = $this->permissions->clean($request->get('permissions'));

        return array_merge($request->all(), ['permissions' => $permissions]);
    }
}
