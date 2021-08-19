<?php

namespace Modules\Polls\Repositories\Eloquent;

use Modules\Polls\Repositories\ResultRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentResultRepository extends EloquentBaseRepository implements ResultRepository
{
    /**
     * @inheritdoc
     */
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

            //Filter by date
            if (isset($filter->date)) {
                $date = $filter->date;//Short filter date
                $date->field = $date->field ?? 'created_at';
                if (isset($date->from))//From a date
                    $query->whereDate($date->field, '>=', $date->from);
                if (isset($date->to))//to a date
                    $query->whereDate($date->field, '<=', $date->to);
            }


            if (isset($filter->question)) {
                $query->where('question_id', $filter->question);
            }
            if (isset($filter->user)) {
                $query->where('user_id', $filter->user);
            }

            if (isset($filter->fill)) {
                $query->where('fill', $filter->fill);
            }
            if (isset($filter->answer)) {
                $query->where('answer_id', $filter->answer);
            }
            if (isset($filter->account)) {
                $query->where('account_id', $filter->account);
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
                $query->where(function ($subQuery) use ($term) {
                    $subQuery->whereHas('translations', function ($q) use ($term) {
                        $q->where('title', 'LIKE', "%{$term}%");
                    })->orWhere('id', $term);
                });

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

            if (isset($filter->question)) {
                $query->where('question_id', $filter->question);
            }
            if (isset($filter->user)) {
                $query->where('user_id', $filter->user);
            }
            if (isset($filter->fill)) {
                $query->where('fill', $filter->fill);
            }
            if (isset($filter->answer)) {
                $query->where('answer_id', $filter->answer);
            }
            if (isset($filter->account)) {
                $query->where('account_id', $filter->account);
            }

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
