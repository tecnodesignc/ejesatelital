<?php

namespace Modules\Company\Http\Controllers\Api;

use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;
use Modules\Company\Http\Requests\CreateAccountRequest;
use Modules\Company\Repositories\AccountRepository;
use Modules\Company\Transformers\AccountTransformer;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Route;
use Log;

class AccountApiController extends BaseApiController
{
    /**
     * @var AccountRepository
     */
    private $account;

    public function __construct(AccountRepository $account)
    {
        parent::__construct();
        $this->account = $account;
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
            $this->validatePermission($request, 'company.accounts.index');

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $accounts = $this->account->getItemsBy($params);

            //Response
            $response = ["data" => AccountTransformer::collection($accounts)];

            //If request pagination add meta-page
            $params->page ? $response["meta"] = ["page" => $this->pageTransformer($accounts)] : false;
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
          //Validate permissions
          $this->validatePermission($request, 'company.accounts.index');
        //Get Parameters from URL.
        $params = $this->getParamsRequest($request);

        //Request to Repository
        $account = $this->account->getItem($criteria, $params);

        //Break if no found item
        if(!$account) throw new Exception(trans('company::accounts.messages.account not found'),404);

        //Response
        $response = ["data" => new AccountTransformer($account)];

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
            $this->validatePermission($request, 'company.accounts.create');

            $data = $request->input('attributes') ?? [];//Get data
            //Validate Request
            $this->validateRequestApi(new CreateAccountRequest($data));

            //Create item
            $account = $this->account->create($data);

            //Response
            $response = ["data" => ['msg' => trans('company::accounts.messages.account created')]];
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
            $this->validatePermission($request, 'company.accounts.edit');
            //Get data
            $data = $request->input('attributes') ?? [];//Get data

            //Validate Request
            $this->validateRequestApi(new CreateAccountRequest($data));

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $account = $this->account->getItem($criteria, $params);

            //Break if no found item
            if(!$account) throw new Exception(trans('company::accounts.messages.account not found'),404);

            //Request to Repository
            $this->account->update($account, $data);

            //Response
            $response = ["data" => ['msg' => trans('company::accounts.messages.account updated')]];
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
            $this->validatePermission($request, 'company.accounts.delete');
            //Get params
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $account = $this->account->getItem($criteria, $params);

            //Break if no found item
            if(!$account) throw new Exception(trans('company::accounts.messages.account not found'),404);

            //call Method delete
            $this->account->destroy($account);

            //Response
            $response = ["data" => ['msg' => trans('company::accounts.messages.account destroy')]];
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
