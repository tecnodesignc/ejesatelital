<?php

namespace Modules\Vehicle\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Modules\Vehicle\Http\Requests\CreateBrandRequest;
use Modules\Vehicle\Http\Requests\UpdateBrandRequest;
use Modules\Vehicle\Repositories\BrandRepository;
use Modules\Vehicle\Transformers\BrandTransformer;

class BrandApiController extends BaseApiController
{
    /**
     * @var BrandRepository
     */
    private $brand;

    public function __construct(BrandRepository $brand)
    {
        parent::__construct();

        $this->brand = $brand;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            //Validate permissions
            $this->validatePermission($request, 'brand.brands.index');

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $brands = $this->brand->getItemsBy($params);

            //Response
            $response = ["data" => BrandTransformer::collection($brands)];

            //If request pagination add meta-page
            $params->page ? $response["meta"] = ["page" => $this->pageTransformer($brands)] : false;
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
            $this->validatePermission($request, 'brand.brands.index');
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $brand = $this->brand->getItem($criteria, $params);

            //Break if no found item
            if (!$brand) throw new \Exception(trans('brand::brands.messages.brand not found'), 404);

            //Response
            $response = ["data" => new BrandTransformer($brand)];

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
            $this->validatePermission($request, 'brand.brands.create');

            $data = $request->input('attributes') ?? [];//Get data
            //Validate Request
            $this->validateRequestApi(new CreateBrandRequest($data));

            //Create item
            $brand = $this->brand->create($data);

            //Response
            $response = ["data" => ['msg' => trans('brand::brands.messages.brand created')]];
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
            //Validate permissions
            $this->validatePermission($request, 'brand.brands.edit');
            //Get data
            $data = $request->input('attributes') ?? [];//Get data

            //Validate Request
            $this->validateRequestApi(new UpdateBrandRequest($data));

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $brand = $this->brand->getItem($criteria, $params);

            //Break if no found item
            if (!$brand) throw new \Exception(trans('brand::brands.messages.brand not found'), 404);

            //Request to Repository
            $this->brand->update($brand, $data);

            //Response
            $response = ["data" => ['msg' => trans('brand::brands.messages.brand updated')]];
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
            $this->validatePermission($request, 'brand.brands.delete');
            //Get params
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $brand = $this->brand->getItem($criteria, $params);

            //Break if no found item
            if (!$brand) throw new \Exception(trans('brand::brands.messages.brand not found'), 404);

            //call Method delete
            $this->brand->destroy($brand);

            //Response
            $response = ["data" => ['msg' => trans('brand::brands.messages.brand destroy')]];
            \DB::commit();//Commit to Data Base
        } catch (\Exception $e) {
            Log::error($e);
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

}
