<?php

namespace Modules\Polls\Http\Controllers\Api;

use http\Params;
use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;
use Modules\Polls\Http\Requests\CreateResultRequest;
use Modules\Polls\Repositories\ResultRepository;
use Modules\Polls\Transformers\ResultTransformer;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Route;
use Log;
use function Aws\filter;

class ResultApiController extends BaseApiController
{
    /**
     * @var ResultRepository
     */
    private $result;

    public function __construct(ResultRepository $result)
    {
        parent::__construct();
        $this->result = $result;
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
            $this->validatePermission($request, 'polls.results.index');

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $results = $this->result->getItemsBy($params);

            //Response
            $response = ["data" => ResultTransformer::collection($results)];

            //If request pagination add meta-page
            $params->page ? $response["meta"] = ["page" => $this->pageTransformer($results)] : false;
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
            //Validate permissions
            $this->validatePermission($request, 'polls.results.index');
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $result = $this->result->getItem($criteria, $params);

            //Break if no found item
            if (!$result) throw new Exception(trans('polls::results.messages.result not found'), 404);

            //Response
            $response = ["data" => new ResultTransformer($result)];

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
            $params = $this->getParamsRequest($request);
            $this->validatePermission($params, 'polls.results.create');

            $data = $request->input('attributes') ?? [];//Get data
            $data['ip'] = $request->getClientIp();
            $data['user_id'] = $params->user->id;
            $params = json_decode(json_encode(["filter"=>["question"=>$data['question_id'],"answer"=>$data['answer_id']],'include'=>[],"take"=>1]));
            //Request to Repository
            $result = $this->result->getItemsBy($params);
            if(count($result))
            $data['fill'] = $result[0]->fill + 1;
            else {
                $this->result->getItemsBy(json_decode(json_encode(['include'=>[],"take"=>1])));
                $data['fill'] = $result[0]->fill??0 + 1;
            }
            //Validate Request
            $this->validateRequestApi(new CreateResultRequest($data));

            //Create item
            $result = $this->result->create($data);

            //Response
            $response = ["data" => ['msg' => trans('polls::results.messages.result created')]];
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
            $this->validatePermission($request, 'polls.results.edit');
            //Get data
            $data = $request->input('attributes') ?? [];//Get data

            //Validate Request
            $this->validateRequestApi(new CreateResultRequest($data));

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $result = $this->result->getItem($criteria, $params);

            //Break if no found item
            if (!$result) throw new Exception(trans('polls::results.messages.result not found'), 404);

            //Request to Repository
            $this->result->update($result, $data);

            //Response
            $response = ["data" => ['msg' => trans('polls::results.messages.result updated')]];
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
            $this->validatePermission($request, 'polls.results.delete');
            //Get params
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $result = $this->result->getItem($criteria, $params);

            //Break if no found item
            if (!$result) throw new Exception(trans('polls::results.messages.result not found'), 404);

            //call Method delete
            $this->result->destroy($result);

            //Response
            $response = ["data" => ['msg' => trans('polls::results.messages.result deleted')]];
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
