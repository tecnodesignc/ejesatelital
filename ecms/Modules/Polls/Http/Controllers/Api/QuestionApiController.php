<?php

namespace Modules\Polls\Http\Controllers\Api;

use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;
use Modules\Polls\Http\Requests\CreateQuestionRequest;
use Modules\Polls\Repositories\QuestionRepository;
use Modules\Polls\Transformers\QuestionTransformer;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Route;
use Log;

class QuestionApiController extends BaseApiController
{
    /**
     * @var QuestionRepository
     */
    private $question;

    public function __construct(QuestionRepository $question)
    {
        parent::__construct();
        $this->question = $question;
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
            $this->validatePermission($request, 'polls.questions.index');

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $questions = $this->question->getItemsBy($params);

            //Response
            $response = ["data" => QuestionTransformer::collection($questions)];

            //If request pagination add meta-page
            $params->page ? $response["meta"] = ["page" => $this->pageTransformer($questions)] : false;
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
          $this->validatePermission($request, 'polls.questions.index');
        //Get Parameters from URL.
        $params = $this->getParamsRequest($request);

        //Request to Repository
        $question = $this->question->getItem($criteria, $params);

        //Break if no found item
        if(!$question) throw new Exception(trans('polls::questions.messages.question not found'),404);

        //Response
        $response = ["data" => new QuestionTransformer($question)];

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
            $this->validatePermission($request, 'polls.questions.create');

            $data = $request->input('attributes') ?? [];//Get data

            //Validate Request
            $this->validateRequestApi(new CreateQuestionRequest($data));

            //Create item
            $question = $this->question->create($data);

            //Response
            $response = ["data" => ['msg' => trans('polls::questions.messages.question created')]];
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
            $this->validatePermission($request, 'polls.questions.edit');
            //Get data
            $data = $request->input('attributes') ?? [];//Get data

            //Validate Request
            $this->validateRequestApi(new CreateQuestionRequest($data));

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $question = $this->question->getItem($criteria, $params);

            //Break if no found item
            if(!$question) throw new Exception(trans('polls::questions.messages.question not found'),404);

            //Request to Repository
            $this->question->update($question, $data);

            //Response
            $response = ["data" => ['msg' => trans('polls::questions.messages.question updated')]];
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
            $this->validatePermission($request, 'polls.questions.delete');
            //Get params
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $question = $this->question->getItem($criteria, $params);

            //Break if no found item
            if(!$question) throw new Exception(trans('polls::questions.messages.question not found'),404);

            //call Method delete
            $this->question->destroy($question);

            //Response
            $response = ["data" => ['msg' => trans('polls::questions.messages.question deleted')]];
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
