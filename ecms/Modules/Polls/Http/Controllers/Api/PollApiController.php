<?php

namespace Modules\Polls\Http\Controllers\Api;

use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;
use Modules\Polls\Http\Requests\CreatePollRequest;
use Modules\Polls\Repositories\PollRepository;
use Modules\Polls\Transformers\PollTransformer;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Route;
use Log;

class PollApiController extends BaseApiController
{
    /**
     * @var PollRepository
     */
    private $poll;

    public function __construct(PollRepository $poll)
    {
        parent::__construct();
        $this->poll = $poll;
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

            //Validate permissions
            $this->validatePermission($params, 'polls.polls.index');

            if(!$params->permissions['polls.polls.all']) $params->filter->account=$params->filter->account??$params->user->accounts[0]->id;

            //Request to Repository
            $polls = $this->poll->getItemsBy($params);

            //Response
            $response = ["data" => PollTransformer::collection($polls)];

            //If request pagination add meta-page
            $params->page ? $response["meta"] = ["page" => $this->pageTransformer($polls)] : false;
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
          $this->validatePermission($request, 'polls.polls.index');
        //Get Parameters from URL.
        $params = $this->getParamsRequest($request);

        //Request to Repository
        $poll = $this->poll->getItem($criteria, $params);

        //Break if no found item
        if(!$poll) throw new Exception(trans('polls::polls.messages.poll not found'),404);

        //Response
        $response = ["data" => new PollTransformer($poll)];

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
            $this->validatePermission($request, 'polls.polls.create');

            $data = $request->input('attributes') ?? [];//Get data
            //Validate Request
            $this->validateRequestApi(new CreatePollRequest($data));

            //Create item
            $poll = $this->poll->create($data);

            //Response
            $response = ["data" => new PollTransformer($poll)];
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
            $this->validatePermission($request, 'polls.polls.edit');
            //Get data
            $data = $request->input('attributes') ?? [];//Get data

            //Validate Request
            $this->validateRequestApi(new CreatePollRequest($data));

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $poll = $this->poll->getItem($criteria, $params);

            //Break if no found item
            if(!$poll) throw new Exception(trans('polls::polls.messages.poll not found'),404);

            //Request to Repository
            $this->poll->update($poll, $data);

            //Response
            $response = ["data" => ['msg' => trans('polls::polls.messages.poll updated')]];
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
            $this->validatePermission($request, 'polls.polls.delete');
            //Get params
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $poll = $this->poll->getItem($criteria, $params);

            //Break if no found item
            if(!$poll) throw new Exception(trans('polls::polls.messages.poll not found'),404);

            //call Method delete
            $this->poll->destroy($poll);

            //Response
            $response = ["data" => ['msg' => trans('polls::polls.messages.poll deleted')]];
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
