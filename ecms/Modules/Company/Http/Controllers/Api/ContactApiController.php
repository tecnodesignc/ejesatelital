<?php

namespace Modules\Company\Http\Controllers\Api;

use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;
use Modules\Company\Http\Requests\CreateContactRequest;
use Modules\Company\Repositories\ContactRepository;
use Modules\Company\Transformers\ContactTransformer;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Route;
use Log;

class ContactApiController extends BaseApiController
{
    /**
     * @var ContactRepository
     */
    private $contact;

    public function __construct(ContactRepository $contact)
    {
        parent::__construct();
        $this->contact = $contact;
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
            $this->validatePermission($request, 'company.contacts.index');

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $contacts = $this->contact->getItemsBy($params);

            //Response
            $response = ["data" => ContactTransformer::collection($contacts)];

            //If request pagination add meta-page
            $params->page ? $response["meta"] = ["page" => $this->pageTransformer($contacts)] : false;
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
          $this->validatePermission($request, 'company.contacts.index');
        //Get Parameters from URL.
        $params = $this->getParamsRequest($request);

        //Request to Repository
        $contact = $this->contact->getItem($criteria, $params);

        //Break if no found item
        if(!$contact) throw new Exception(trans('company::contacts.messages.contact not found'),404);

        //Response
        $response = ["data" => new ContactTransformer($contact)];

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
            $this->validatePermission($request, 'company.contacts.create');

            $data = $request->input('attributes') ?? [];//Get data
            //Validate Request
            $this->validateRequestApi(new CreateContactRequest($data));

            //Create item
            $contact = $this->contact->create($data);

            //Response
            $response = ["data" => ['msg' => trans('company::contacts.messages.contact created')]];
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
            $this->validatePermission($request, 'company.contacts.edit');
            //Get data
            $data = $request->input('attributes') ?? [];//Get data

            //Validate Request
            $this->validateRequestApi(new CreateContactRequest($data));

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $contact = $this->contact->getItem($criteria, $params);

            //Break if no found item
            if(!$contact) throw new Exception(trans('company::contacts.messages.contact not found'),404);

            //Request to Repository
            $this->contact->update($contact, $data);

            //Response
            $response = ["data" => ['msg' => trans('company::contacts.messages.contact updated')]];
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
            $this->validatePermission($request, 'company.contacts.delete');
            //Get params
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $contact = $this->contact->getItem($criteria, $params);

            //Break if no found item
            if(!$contact) throw new Exception(trans('company::contacts.messages.contact not found'),404);

            //call Method delete
            $this->contact->destroy($contact);

            //Response
            $response = ["data" => ['msg' => trans('company::contacts.messages.contact destroy')]];
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
