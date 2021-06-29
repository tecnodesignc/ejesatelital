<?php

namespace Modules\Location\Http\Controllers\Api;

use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;
use Modules\Location\Http\Requests\CreateCountryRequest;
use Modules\Location\Repositories\CountryRepository;
use Modules\Location\Transformers\CountryTransformer;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Route;
use Log;

class CountryApiController extends BaseApiController
{
    /**
     * @var CountryRepository
     */
    private $country;

    public function __construct(CountryRepository $country)
    {
        parent::__construct();
        $this->country = $country;
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
            $countries = $this->country->getItemsBy($params);

            //Response
            $response = ["data" => CountryTransformer::collection($countries)];

            //If request pagination add meta-page
            $params->page ? $response["meta"] = ["page" => $this->pageTransformer($countries)] : false;
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
        $country = $this->country->getItem($criteria, $params);

        //Break if no found item
        if(!$country) throw new Exception(trans('location::countries.messages.country not found'),404);

        //Response
        $response = ["data" => new CountryTransformer($country)];

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
            $this->validateRequestApi(new CreateCountryRequest($data));

            //Create item
            $country = $this->country->create($data);

            //Response
            $response = ["data"=> ['msg' => trans('location::countries.messages.country created')]];
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
            $this->validateRequestApi(new CreateCountryRequest($data));

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $country = $this->country->getItem($criteria, $params);

            //Break if no found item
            if(!$country) throw new Exception(trans('location::countries.messages.country not found'),404);
            //Request to Repository
            $this->country->update($country, $data);

            //Response
            $response = ["data"=> ['msg' => trans('location::countries.messages.country updated')]];
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
            $country = $this->country->getItem($criteria, $params);

            //Break if no found item
            if(!$country) throw new Exception(trans('location::countries.messages.country not found'),404);

            //call Method delete
            $this->country->destroy($country);

            //Response
            $response = ["data" => ['msg' =>  trans('location::countries.messages.country deleted')]];
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
