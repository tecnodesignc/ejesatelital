<?php

namespace Modules\Polls\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Polls\Entities\QuestionType;
use Modules\Polls\Http\Requests\CreateQuestionTypeRequest;
use Modules\Polls\Http\Requests\UpdateQuestionTypeRequest;
use Modules\Polls\Repositories\QuestionTypeRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class QuestionTypeController extends AdminBaseController
{
    /**
     * @var QuestionTypeRepository
     */
    private $questiontype;

    public function __construct(QuestionTypeRepository $questiontype)
    {
        parent::__construct();

        $this->questiontype = $questiontype;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$questiontypes = $this->questiontype->all();

        return view('polls::admin.questiontypes.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('polls::admin.questiontypes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateQuestionTypeRequest $request
     * @return Response
     */
    public function store(CreateQuestionTypeRequest $request)
    {
        $this->questiontype->create($request->all());

        return redirect()->route('admin.polls.questiontype.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('polls::questiontypes.title.questiontypes')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  QuestionType $questiontype
     * @return Response
     */
    public function edit(QuestionType $questiontype)
    {
        return view('polls::admin.questiontypes.edit', compact('questiontype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  QuestionType $questiontype
     * @param  UpdateQuestionTypeRequest $request
     * @return Response
     */
    public function update(QuestionType $questiontype, UpdateQuestionTypeRequest $request)
    {
        $this->questiontype->update($questiontype, $request->all());

        return redirect()->route('admin.polls.questiontype.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('polls::questiontypes.title.questiontypes')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  QuestionType $questiontype
     * @return Response
     */
    public function destroy(QuestionType $questiontype)
    {
        $this->questiontype->destroy($questiontype);

        return redirect()->route('admin.polls.questiontype.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('polls::questiontypes.title.questiontypes')]));
    }
}
