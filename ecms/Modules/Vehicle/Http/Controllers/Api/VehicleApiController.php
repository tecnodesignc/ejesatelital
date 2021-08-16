<?php

namespace Modules\Vehicle\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Modules\Vehicle\Http\Requests\CreateVehicleRequest;
use Modules\Vehicle\Http\Requests\UpdateVehicleRequest;
use Modules\Vehicle\Repositories\VehicleRepository;
use Modules\Vehicle\Transformers\VehicleTransformer;

class VehicleApiController extends BaseApiController
{
    /**
     * @var VehicleRepository
     */
    private $vehicle;

    public function __construct(VehicleRepository $vehicle)
    {
        parent::__construct();

        $this->vehicle = $vehicle;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        try {
            //Validate permissions
            $this->validatePermission($request, 'vehicle.vehicles.index');

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $vehicles = $this->vehicle->getItemsBy($params);

            //Response
            $response = ["data" => VehicleTransformer::collection($vehicles)];

            //If request pagination add meta-page
            $params->page ? $response["meta"] = ["page" => $this->pageTransformer($vehicles)] : false;
        } catch (\Exception $e) {
            \Log::Error($e);
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
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
            //Validate permissions
            $this->validatePermission($request, 'vehicle.vehicles.index');
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $vehicle = $this->vehicle->getItem($criteria, $params);

            //Break if no found item
            if (!$vehicle) throw new \Exception(trans('vehicle::vehicles.messages.vehicle not found'), 404);

            //Response
            $response = ["data" => new VehicleTransformer($vehicle)];

        } catch (\Exception $e) {
            \Log::error($e);
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
            //Validate permissions
            $this->validatePermission($request, 'vehicle.vehicles.create');

            $data = $request->input('attributes') ?? [];//Get data


            //Validate Request
            $this->validateRequestApi(new CreateVehicleRequest($request));

            //Create item
            $vehicle = $this->vehicle->create($data);

            //Response
            $response = ["data" => ['msg' => trans('vehicle::vehicles.messages.vehicle created')]];
            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
            \Log::Error($e);
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }
        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
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
            //Validate permissions
            $this->validatePermission($request, 'vehicle.vehicles.edit');
            //Get data
            $data = $request->input('attributes') ?? [];//Get data

            //Validate Request
            $this->validateRequestApi(new UpdateVehicleRequest($data));

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $vehicle = $this->vehicle->getItem($criteria, $params);

            //Break if no found item
            if (!$vehicle) throw new \Exception(trans('vehicle::vehicles.messages.vehicle not found'), 404);

            //Request to Repository
            $this->vehicle->update($vehicle, $data);

            //Response
            $response = ["data" => ['msg' => trans('vehicle::vehicles.messages.vehicle updated')]];
            \DB::commit();//Commit to DataBase
        } catch (\Exception $e) {
            \Log::error($e);
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
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
            //Validate permissions
            $this->validatePermission($request, 'vehicle.vehicles.delete');
            //Get params
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $vehicle = $this->vehicle->getItem($criteria, $params);

            //Break if no found item
            if (!$vehicle) throw new \Exception(trans('vehicle::vehicles.messages.vehicle not found'), 404);

            //call Method delete
            $this->vehicle->destroy($vehicle);

            //Response
            $response = ["data" => ['msg' => trans('vehicle::vehicles.messages.vehicle destroy')]];
            \DB::commit();//Commit to Data Base
        } catch (\Exception $e) {
            \Log::error($e);
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

}
