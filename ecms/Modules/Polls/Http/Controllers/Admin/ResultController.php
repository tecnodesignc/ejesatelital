<?php

namespace Modules\Polls\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Polls\Entities\Result;
use Modules\Polls\Http\Requests\CreateResultRequest;
use Modules\Polls\Http\Requests\UpdateResultRequest;
use Modules\Polls\Repositories\ResultRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class ResultController extends AdminBaseController
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
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$results = $this->result->all();

        return view('polls::admin.results.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('polls::admin.results.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateResultRequest $request
     * @return Response
     */
    public function store(CreateResultRequest $request)
    {
        $this->result->create($request->all());

        return redirect()->route('admin.polls.result.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('polls::results.title.results')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Result $result
     * @return Response
     */
    public function edit(Result $result)
    {
        return view('polls::admin.results.edit', compact('result'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Result $result
     * @param  UpdateResultRequest $request
     * @return Response
     */
    public function update(Result $result, UpdateResultRequest $request)
    {
        $this->result->update($result, $request->all());

        return redirect()->route('admin.polls.result.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('polls::results.title.results')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Result $result
     * @return Response
     */
    public function destroy(Result $result)
    {
        $this->result->destroy($result);

        return redirect()->route('admin.polls.result.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('polls::results.title.results')]));
    }
}
