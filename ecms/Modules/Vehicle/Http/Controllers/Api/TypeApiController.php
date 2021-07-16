<?php

namespace Modules\Vehicle\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Modules\Vehicle\Entities\Type;
use Modules\Vehicle\Transformers\TypeVehicleTransformer;

class TypeApiController extends BaseApiController
{
    /**
     * @var Type
     */
    private $type;

    public function __construct(Type $type)
    {
        parent::__construct();

        $this->type = $type;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $types = $this->type->lists();

            //Response
            $response = ["data" => TypeVehicleTransformer::collection($types)];

            //If request pagination add meta-page
            $params->page ? $response["meta"] = ["page" => $this->pageTransformer($types)] : false;
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

            //Request to Repository
            $type = $this->type->getItem($criteria, $params);

            //Break if no found item
            if (!$type) throw new \Exception(trans('vehicle:types.messages.type not found'), 404);

            //Response
            $response = ["data" => new TypeVehicleTransformer($type)];

        } catch (\Exception $e) {
            \Log::error($e);
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }

}
