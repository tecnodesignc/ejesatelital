<?php

namespace Modules\Polls\Http\Controllers\Api;

use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;
use Modules\Polls\Http\Requests\CreateAnswerRequest;
use Modules\Polls\Repositories\AnswerRepository;
use Modules\Polls\Transformers\AnswerTransformer;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Route;
use Log;

class AnswerApiController extends BaseApiController
{
    /**
     * @var AnswerRepository
     */
    private $answer;

    public function __construct(AnswerRepository $answer)
    {
        parent::__construct();
        $this->answer = $answer;
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
            $this->validatePermission($request, 'polls.answers.index');

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $answers = $this->answer->getItemsBy($params);

            //Response
            $response = ["data" => AnswerTransformer::collection($answers)];

            //If request pagination add meta-page
            $params->page ? $response["meta"] = ["page" => $this->pageTransformer($answers)] : false;
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
          $this->validatePermission($request, 'polls.answers.index');
        //Get Parameters from URL.
        $params = $this->getParamsRequest($request);

        //Request to Repository
        $answer = $this->answer->getItem($criteria, $params);

        //Break if no found item
        if(!$answer) throw new Exception(trans('polls::answers.messages.answer not found'),404);

        //Response
        $response = ["data" => new AnswerTransformer($answer)];

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
            $this->validatePermission($request, 'polls.answers.create');

            $data = $request->input('attributes') ?? [];//Get data

            //Validate Request
            $this->validateRequestApi(new CreateAnswerRequest($data));

            //Create item
            $answer = $this->answer->create($data);

            //Response
            $response = ["data" => ['msg' => trans('polls::answers.messages.answer created')]];
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
            $this->validatePermission($request, 'polls.answers.edit');
            //Get data
            $data = $request->input('attributes') ?? [];//Get data

            //Validate Request
            $this->validateRequestApi(new CreateAnswerRequest($data));

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $answer = $this->answer->getItem($criteria, $params);

            //Break if no found item
            if(!$answer) throw new Exception(trans('polls::answers.messages.answer not found'),404);

            //Request to Repository
            $this->answer->update($answer, $data);

            //Response
            $response = ["data" => ['msg' => trans('polls::answers.messages.answer updated')]];
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
            $this->validatePermission($request, 'polls.answers.delete');
            //Get params
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $answer = $this->answer->getItem($criteria, $params);

            //Break if no found item
            if(!$answer) throw new Exception(trans('polls::answers.messages.answer not found'),404);

            //call Method delete
            $this->answer->destroy($answer);

            //Response
            $response = ["data" => ['msg' => trans('polls::answers.messages.answer deleted')]];
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
