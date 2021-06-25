<?php

namespace Modules\Company\Repositories\Eloquent;

use Modules\Company\Events\AccountWasCreated;
use Modules\Company\Events\AccountWasDeleted;
use Modules\Company\Events\AccountWasUpdated;
use Modules\Company\Repositories\AccountRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Illuminate\Support\Arr;

class EloquentAccountRepository extends EloquentBaseRepository implements AccountRepository
{

    /**
     * create a resource
     * Create a blog account
     * @param array $data
     * @return Account
     */
    public function create($data)
    {
        $account = $this->model->create($data);
        $account->users()->sync(Arr::get($data, 'users', []));
        event(new AccountWasCreated($account, $data));
        return $account;
    }

    /**
     * Update a resource
     * @param $account
     * @param array $data
     * @return mixed
     */
    public function update($account, $data)
    {
        $account->update($data);
        $account->users()->sync(Arr::get($data, 'users', []));
        event(new AccountWasUpdated($account, $data));
        return $account;
    }

    /**
     * Delete a resource
     * @param $model
     * @return mixed
     */
    public function destroy($model)
    {

        event(new AccountWasDeleted($model->id, get_class($model)));

        return $model->delete();
    }

    /**
     * Standard Api Method
     * @param bool $params
     * @return mixed
     */
    public function getItemsBy($params = false)
    {
        /*== initialize query ==*/
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include)) {//If Request all relationships
            $query->with(['users','contacts','type']);
        } else {//Especific relationships
            $includeDefault = [];//Default relationships
            if (isset($params->include))//merge relations with default relationships
                $includeDefault = array_merge($includeDefault, $params->include);
            $query->with($includeDefault);//Add Relationships to query
        }

        /*== FILTERS ==*/
        if (isset($params->filter)) {
            $filter = $params->filter;//Short filter
            if (isset($filter->users) && !empty($filter->users)) {
                $categories = is_array($filter->users) ? $filter->users : [$filter->users];
                $query->whereHas('users', function ($q) use ($categories) {
                    $q->whereIn('user_id', $categories);
                });
            }
            if (isset($filter->parents) && !empty($filter->parents)) {
                $parents = is_array($filter->parents) ? $filter->parents : [$filter->parents];
                $query->whereIn('parent', $parents);
            }
            if (isset($filter->type) && !empty($filter->type)) {
                $type = is_array($filter->type) ? $filter->type : [$filter->type];
                $query->whereIn('account_type_id', $type);
            }
            if (isset($filter->cities) && !empty($filter->cities)) {
                $cities = is_array($filter->cities) ? $filter->cities : [$filter->cities];
                $query->whereIn('city', $cities);
            }
            if (isset($filter->states) && !empty($filter->states)) {
                $states = is_array($filter->states) ? $filter->states : [$filter->states];
                $query->whereIn('state', $states);
            }
            if (isset($filter->countries) && !empty($filter->countries)) {
                $countries = is_array($filter->countries) ? $filter->countries : [$filter->countries];
                $query->whereIn('countries', $countries);
            }


            if (isset($filter->search) && !empty($filter->search)) { //si hay que filtrar por rango de precio

                $query->where(function ($query) use ($filter) {
                    $query->where('id', 'like', '%' . $filter->search . '%')
                        ->orWhere('name', 'like', '%' . $filter->search . '%')
                        ->orWhere('nit', 'like', '%' . $filter->search . '%')
                        ->orWhere('phone', 'like', '%' . $filter->search . '%')
                        ->orWhere('state', 'like', '%' . $filter->search . '%')
                        ->orWhere('country', 'like', '%' . $filter->search . '%')
                        ->orWhere('city', 'like', '%' . $filter->search . '%');
                });

            }
            //Filter by date
            if (isset($filter->date) && !empty($filter->date)) {
                $date = $filter->date;//Short filter date
                $date->field = $date->field ?? 'created_at';
                if (isset($date->from))//From a date
                    $query->whereDate($date->field, '>=', $date->from);
                if (isset($date->to))//to a date
                    $query->whereDate($date->field, '<=', $date->to);
            }

            //Order by
            if (isset($filter->order) && !empty($filter->order)) {
                $orderByField = $filter->order->field ?? 'created_at';//Default field
                $orderWay = $filter->order->way ?? 'desc';//Default way
                $query->orderBy($orderByField, $orderWay);//Add order to query
            }

            if (isset($filter->status)) {
                $query->whereActive($filter->status);
            }

        }

        /*== FIELDS ==*/
        if (isset($params->fields) && count($params->fields))
            $query->select($params->fields);
        /*== REQUEST ==*/
        if (isset($params->page) && $params->page) {
            return $query->paginate($params->take);
        } else {
            if (isset($params->skip) && !empty($params->skip)) {
                $query->skip($params->skip);
            };

            $params->take ? $query->take($params->take) : false;//Take

            return $query->get();
        }
    }

    /**
     * Standard Api Method
     * @param $criteria
     * @param bool $params
     * @return mixed
     */
    public function getItem($criteria, $params = false)
    {
        //Initialize query
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include)) {//If Request all relationships
            $query->with(['translations']);
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

            // find translatable attributes
            $translatedAttributes = $this->model->translatedAttributes;

            // filter by translatable attributes
            if (isset($field) && in_array($field, $translatedAttributes))//Filter by slug
                $query->whereHas('translations', function ($query) use ($criteria, $filter, $field) {
                    $query->where('locale', $filter->locale)
                        ->where($field, $criteria);
                });
            else
                // find by specific attribute or by id
                $query->where($field ?? 'id', $criteria);
        }

        /*== FIELDS ==*/
        if (isset($params->fields) && count($params->fields))
            $query->select($params->fields);

        /*== REQUEST ==*/
        return $query->first();

    }
}
