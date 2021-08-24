<?php

namespace Modules\Notification\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Modules\Notification\Http\Requests\CreateNotificationRequest;
use Modules\Notification\Repositories\NotificationRepository;
use Modules\Notification\Transformers\NotificationTransformer;
use Modules\Notification\Services\Notification;

class NotificationsController extends BaseApiController
{
    /**
     * @var NotificationRepository
     */
    private $notification;

    /**
     * @var Notification
     */
    private $serviceNotification;


    public function __construct(NotificationRepository $notification, Notification $serviceNotification)
    {
        $this->notification = $notification;
        $this->serviceNotification = $serviceNotification;
    }

    public function markAsRead(Request $request)
    {
        $updated = $this->notification->markNotificationAsRead($request->get('id'));

        return response()->json(compact('updated'));
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
            $this->validatePermission($params, 'notification.notifications.index');

            //Request to Repository
            $notifications = $this->notification->getItemsBy($params);

            //Response
            $response = ["data" => NotificationTransformer::collection($notifications)];

            //If request pagination add meta-page
            $params->page ? $response["meta"] = ["page" => $this->pageTransformer($notifications)] : false;
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
            $this->validatePermission($request, 'notification.notifications.index');
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $notification = $this->notification->getItem($criteria, $params);

            //Break if no found item
            if (!$notification) throw new \Exception(trans('notification:messages.messages.notification not found'), 404);

            //Response
            $response = ["data" => new NotificationTransformer($notification)];

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

            // $this->validatePermission($params, 'notification.notifications.create');

            $data = $request->input('attributes') ?? [];//Get data
            //Validate Request

            if (isset($data['user_id'])) {
                $this->serviceNotification->to($data['user_id'])->push($data['title'], $data['caption'] ?? '', $data['entity'] ?? '', $data['link']);
            } elseif (isset($data['account_id'])) {
                $this->serviceNotification->account($data['account_id'])->push($data['title'], $data['caption'] ?? '', $data['entity'] ?? '', $data['link']);
            } else {
                $this->serviceNotification->push($data['title'], $data['caption'] ?? '', $data['entity'] ?? '', $data['link']);
            }

            //Response
            $response = ["data" => ['msg' => trans('notification:messages.messages.notification created')]];
            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
            \Log::Error($e);
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
            $this->validatePermission($request, 'notification.notifications.edit');
            //Get data
            $data = $request->input('attributes') ?? [];//Get data

            //Validate Request
            $this->validateRequestApi(new CreateNotificationRequest($data));

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $notification = $this->notification->getItem($criteria, $params);

            //Break if no found item
            if (!$notification) throw new \Exception(trans('notification:messages.messages.notification not found'), 404);

            //Request to Repository
            $this->notification->update($notification, $data);

            //Response
            $response = ["data" => ['msg' => trans('notification:messages.messages.notification updated')]];
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
            $this->validatePermission($request, 'notification.notifications.delete');
            //Get params
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $notification = $this->notification->getItem($criteria, $params);

            //Break if no found item
            if (!$notification) throw new \Exception(trans('notification:messages.messages.notification not found'), 404);

            //call Method delete
            $this->notification->destroy($notification);

            //Response
            $response = ["data" => ['msg' => trans('notification:messages.messages.notification destroy')]];
            \DB::commit();//Commit to Data Base
        } catch (\Exception $e) {
            \Log::error($e);
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

    public function marksAsRead(Request $request)
    {
        try {
            $params = $this->getParamsRequest($request);

            // $this->validatePermission($params, 'notification.notifications.create');

            $data = $request->input('attributes') ?? [];//Get data
            //Validate Request
            foreach ($data['ids'] as $item) {
                $this->notification->markNotificationAsRead($item);
            }
        } catch (\Exception $e) {
            \Log::error($e);
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }
        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

}
