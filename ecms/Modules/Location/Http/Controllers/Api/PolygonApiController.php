<?php

namespace Modules\Location\Http\Controllers\Api;

use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;
use Modules\Location\Http\Requests\CreatePolygonRequest;
use Modules\Location\Repositories\PolygonRepository;
use Modules\Location\Transformers\PolygonTransformer;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Route;
use Log;

class PolygonApiController extends BaseApiController
{
    /**
     * @var PolygonRepository
     */
    private $polygon;

    public function __construct(PolygonRepository $polygon)
    {
        parent::__construct();
        $this->polygon = $polygon;
    }

    /**
     * GET ITEMS
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $polygons = $this->polygon->getItemsBy($params);

            //Response
            $response = ["data" => PolygonTransformer::collection($polygons)];

            //If request pagination add meta-page
            $params->page ? $response["meta"] = ["page" => $this->pageTransformer($polygons)] : false;
        } catch (\Exception $e) {
            Log::Error($e);
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
    public function show($criteria,Request $request)
    {
      try {
        //Get Parameters from URL.
        $params = $this->getParamsRequest($request);

        //Request to Repository
        $polygon = $this->polygon->getItem($criteria, $params);

        //Break if no found item
        if(!$polygon) throw new Exception(trans('location::polygons.messages.polygon not found'),404);

        //Response
        $response = ["data" => new PolygonTransformer($polygon)];

      } catch (\Exception $e) {
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
            $data = $request->input('attributes') ?? [];//Get data
            //Validate Request
            $this->validateRequestApi(new CreatePolygonRequest($data));

            //Create item
            $polygon = $this->polygon->create($data);

            //Response
            $response = ["data"=> ['msg' => trans('location::polygons.messages.polygon created')]];
            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
            Log::Error($e);
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
            //Get data
            $data = $request->input('attributes') ?? [];//Get data

            //Validate Request
            $this->validateRequestApi(new CreatePolygonRequest($data));

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $polygon = $this->polygon->getItem($criteria, $params);

            //Break if no found item
            if(!$polygon) throw new Exception(trans('location::polygons.messages.polygon not found'),404);
            //Request to Repository
            $this->polygon->update($polygon, $data);

            //Response
            $response = ["data"=> ['msg' => trans('location::polygons.messages.polygon updated')]];
            \DB::commit();//Commit to DataBase
        } catch (\Exception $e) {
            Log::Error($e);
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
            //Get params
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $polygon = $this->polygon->getItem($criteria, $params);

            //Break if no found item
            if(!$polygon) throw new Exception(trans('location::polygons.messages.polygon not found'),404);

            //call Method delete
            $this->polygon->destroy($polygon);

            //Response
            $response = ["data" => ['msg' =>  trans('location::polygons.messages.polygon deleted')]];
            \DB::commit();//Commit to Data Base
        } catch (\Exception $e) {
            Log::Error($e);
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

}
