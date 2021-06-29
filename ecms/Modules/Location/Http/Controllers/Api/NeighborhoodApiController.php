<?php

namespace Modules\Location\Http\Controllers\Api;

use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;
use Modules\Location\Http\Requests\CreateNeighborhoodRequest;
use Modules\Location\Repositories\NeighborhoodRepository;
use Modules\Location\Transformers\NeighborhoodTransformer;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Route;
use Log;

class NeighborhoodApiController extends BaseApiController
{
    /**
     * @var NeighborhoodRepository
     */
    private $neighborhood;

    public function __construct(NeighborhoodRepository $neighborhood)
    {
        parent::__construct();
        $this->neighborhood = $neighborhood;
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
            $neighborhoods = $this->neighborhood->getItemsBy($params);

            //Response
            $response = ["data" => NeighborhoodTransformer::collection($neighborhoods)];

            //If request pagination add meta-page
            $params->page ? $response["meta"] = ["page" => $this->pageTransformer($neighborhoods)] : false;
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
        $neighborhood = $this->neighborhood->getItem($criteria, $params);

        //Break if no found item
        if(!$neighborhood) throw new Exception(trans('location::neighborhoods.messages.neighborhood not found'),404);

        //Response
        $response = ["data" => new NeighborhoodTransformer($neighborhood)];

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
            $this->validateRequestApi(new CreateNeighborhoodRequest($data));

            //Create item
            $neighborhood = $this->neighborhood->create($data);

            //Response
            $response = ["data"=> ['msg' => trans('location::neighborhoods.messages.neighborhood created')]];
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
            $this->validateRequestApi(new CreateNeighborhoodRequest($data));

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $neighborhood = $this->neighborhood->getItem($criteria, $params);

            //Break if no found item
            if(!$neighborhood) throw new Exception(trans('location::neighborhoods.messages.neighborhood not found'),404);
            //Request to Repository
            $this->neighborhood->update($neighborhood, $data);

            //Response
            $response = ["data"=> ['msg' => trans('location::neighborhoods.messages.neighborhood updated')]];
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
            $neighborhood = $this->neighborhood->getItem($criteria, $params);

            //Break if no found item
            if(!$neighborhood) throw new Exception(trans('location::neighborhoods.messages.neighborhood not found'),404);

            //call Method delete
            $this->neighborhood->destroy($neighborhood);

            //Response
            $response = ["data" => ['msg' =>  trans('location::neighborhoods.messages.neighborhood deleted')]];
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
