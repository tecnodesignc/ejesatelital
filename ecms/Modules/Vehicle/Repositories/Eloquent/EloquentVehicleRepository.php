<?php

namespace Modules\Vehicle\Repositories\Eloquent;

use Modules\Vehicle\Events\VehicleWasCreated;
use Modules\Vehicle\Events\VehicleWasDeleted;
use Modules\Vehicle\Events\VehicleWasUpdated;
use Modules\Vehicle\Repositories\VehicleRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Illuminate\Support\Arr;

class EloquentVehicleRepository extends EloquentBaseRepository implements VehicleRepository
{


    /**
     * create a resource
     * Create a blog vehicle
     * @param array $data
     * @return Post
     */
    public function create($data)
    {
        $vehicle = $this->model->create($data);
        $vehicle->drivers()->sync(Arr::get($data, 'drivers', []));
        $vehicle->accounts()->sync(Arr::get($data, 'accounts', []));
        event(new VehicleWasCreated($vehicle, $data));

        return $vehicle;
    }

    /**
     * Update a resource
     * @param $vehicle
     * @param array $data
     * @return mixed
     */
    public function update($vehicle, $data)
    {
        $vehicle->update($data);
        $vehicle->drivers()->sync(Arr::get($data, 'drivers', []));
        $vehicle->accounts()->sync(Arr::get($data, 'accounts', []));
        event(new VehicleWasUpdated($vehicle, $data));


        return $vehicle;
    }

    /**
     * Delete a resource
     * @param $model
     * @return mixed
     */
    public function destroy($model)
    {

        event(new VehicleWasDeleted($model->id, get_class($model)));

        return $model->delete();
    }


    public function getItemsBy($params = false)
    {

        /*== initialize query ==*/
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include)) {//If Request all relationships
            $query->with([]);
        } else {//Especific relationships
            $includeDefault = [];//Default relationships
            if (isset($params->include))//merge relations with default relationships
                $includeDefault = array_merge($includeDefault, $params->include);
            $query->with($includeDefault);//Add Relationships to query
        }


        /*== FILTERS ==*/
        if (isset($params->filter)) {
            $filter = $params->filter;//Short filter


            /*   if (isset($filter->status)) {
                   $query->whereStatus($filter->status);
               }*/


            //Filter by date
            if (isset($filter->date)) {
                $date = $filter->date;//Short filter date
                $date->field = $date->field ?? 'created_at';
                if (isset($date->from))//From a date
                    $query->whereDate($date->field, '>=', $date->from);
                if (isset($date->to))//to a date
                    $query->whereDate($date->field, '<=', $date->to);
            }
            if (isset($filter->accounts)) {
                $accounts = is_array($filter->accounts) ? $filter->accounts : [$filter->accounts];
                $query->whereHas('accounts', function ($q) use ($accounts) {
                    $q->whereIn('account_id', $accounts);
                });
            } elseif (!isset($params->permissions['vehicle.vehicles.all'])||!$params->permissions['vehicle.vehicles.all']) {
                $query->whereHas('accounts', function ($q) use ($params) {

                    $q->where('account_id', $params->user->accounts[0]->id??0);
                });
            }

            //Order by
            if (isset($filter->order)) {
                $orderByField = $filter->order->field ?? 'created_at';//Default field
                $orderWay = $filter->order->way ?? 'desc';//Default way
                $query->orderBy($orderByField, $orderWay);//Add order to query
            }

            //add filter by search
            if (isset($filter->search) && $filter->search) {
                //find search in columns
                $term = $filter->search;
                $query->where('board', 'LIKE', "%{$term}%")->orWhere('id', $term);
            }
        }

        /*== FIELDS ==*/
        if (isset($params->fields) && count($params->fields))
            $query->select($params->fields);

        /*== REQUEST ==*/
        if (isset($params->page) && $params->page) {
            return $query->paginate($params->take);
        } else {
            $params->take ? $query->take($params->take) : false;//Take
            return $query->get();
        }
    }

    /**
     * @inheritdoc
     */

    public function getItem($criteria, $params = false)
    {
        //Initialize query
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include)) {//If Request all relationships
            $query->with([]);
        } else {//Especific relationships
            $includeDefault = [];//Default relationships
            if (isset($params->include))//merge relations with default relationships
                $includeDefault = array_merge($includeDefault, $params->include);
            $query->with($includeDefault);//Add Relationships to query
        }

        /*== FILTER ==*/
        if (isset($params->filter)) {
            $filter = $params->filter;


            if (isset($filter->field))//Filter by specific field
                $field = $filter->field;
        }

        /*== FIELDS ==*/
        if (isset($params->fields) && count($params->fields))
            $query->select($params->fields);

        /*== REQUEST ==*/
        return $query->where($field ?? 'id', $criteria)->first();
    }

}
