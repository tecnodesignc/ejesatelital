<?php

namespace Modules\Custom\Http\Controllers\Api;

use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;
use Modules\Location\Http\Requests\CreateCityRequest;
use Modules\Location\Repositories\CityRepository;
use Modules\Location\Transformers\CityTransformer;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Route;
use Log;

class GpsApiController extends BaseApiController
{
    /**
     * @var CityRepository
     */
    private $city;

    public function __construct(CityRepository $city)
    {
        parent::__construct();
        $this->city = $city;
    }

    /**
     * GET ITEMS
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        try {
            $response =$request->all();
            \Log::info(json_encode($response));
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
    public function show($criteria, Request $request)
    {
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $city = $this->city->getItem($criteria, $params);

            //Break if no found item
            if (!$city) throw new Exception(trans('location::cities.messages.city not found'), 404);

            //Response
            $response = ["data" => new CityTransformer($city)];

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
            $this->validateRequestApi(new CreateCityRequest($data));

            //Create item
            $city = $this->city->create($data);

            //Response
            $response = ["data" => ['msg' => trans('location::cities.messages.city created')]];
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
            $this->validateRequestApi(new CreateCityRequest($data));

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $city = $this->city->getItem($criteria, $params);

            //Break if no found item
            if (!$city) throw new Exception(trans('location::cities.messages.city not found'), 404);
            //Request to Repository
            $this->city->update($city, $data);

            //Response
            $response = ["data" => ['msg' => trans('location::cities.messages.city updated')]];
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
            $city = $this->city->getItem($criteria, $params);

            //Break if no found item
            if (!$city) throw new Exception(trans('location::cities.messages.city not found'), 404);

            //call Method delete
            $this->city->destroy($city);

            //Response
            $response = ["data" => ['msg' => trans('location::cities.messages.city deleted')]];
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
