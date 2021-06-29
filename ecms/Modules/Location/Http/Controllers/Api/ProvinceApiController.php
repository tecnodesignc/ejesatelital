<?php

namespace Modules\Location\Http\Controllers\Api;

use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;
use Modules\Location\Http\Requests\CreateProvinceRequest;
use Modules\Location\Repositories\ProvinceRepository;
use Modules\Location\Transformers\ProvinceTransformer;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Route;
use Log;

class ProvinceApiController extends BaseApiController
{
    /**
     * @var ProvinceRepository
     */
    private $province;

    public function __construct(ProvinceRepository $province)
    {
        parent::__construct();
        $this->province = $province;
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
            $provinces = $this->province->getItemsBy($params);

            //Response
            $response = ["data" => ProvinceTransformer::collection($provinces)];

            //If request pagination add meta-page
            $params->page ? $response["meta"] = ["page" => $this->pageTransformer($provinces)] : false;
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
        $province = $this->province->getItem($criteria, $params);

        //Break if no found item
        if(!$province) throw new Exception(trans('location::provinces.messages.province not found'),404);

        //Response
        $response = ["data" => new ProvinceTransformer($province)];

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
            $this->validateRequestApi(new CreateProvinceRequest($data));

            //Create item
            $province = $this->province->create($data);

            //Response
            $response = ["data"=> ['msg' => trans('location::provinces.messages.province created')]];
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
            $this->validateRequestApi(new CreateProvinceRequest($data));

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $province = $this->province->getItem($criteria, $params);

            //Break if no found item
            if(!$province) throw new Exception(trans('location::provinces.messages.province not found'),404);
            //Request to Repository
            $this->province->update($province, $data);

            //Response
            $response = ["data"=> ['msg' => trans('location::provinces.messages.province updated')]];
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
            $province = $this->province->getItem($criteria, $params);

            //Break if no found item
            if(!$province) throw new Exception(trans('location::provinces.messages.province not found'),404);

            //call Method delete
            $this->province->destroy($province);

            //Response
            $response = ["data" => ['msg' =>  trans('location::provinces.messages.province deleted')]];
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
