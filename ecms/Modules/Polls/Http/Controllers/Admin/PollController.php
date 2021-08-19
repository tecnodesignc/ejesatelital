<?php

namespace Modules\Polls\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Polls\Entities\Poll;
use Modules\Polls\Http\Requests\CreatePollRequest;
use Modules\Polls\Http\Requests\UpdatePollRequest;
use Modules\Polls\Repositories\PollRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class PollController extends AdminBaseController
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
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$polls = $this->poll->all();

        return view('polls::admin.polls.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('polls::admin.polls.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePollRequest $request
     * @return Response
     */
    public function store(CreatePollRequest $request)
    {
        $this->poll->create($request->all());

        return redirect()->route('admin.polls.poll.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('polls::polls.title.polls')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Poll $poll
     * @return Response
     */
    public function edit(Poll $poll)
    {
        return view('polls::admin.polls.edit', compact('poll'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Poll $poll
     * @param  UpdatePollRequest $request
     * @return Response
     */
    public function update(Poll $poll, UpdatePollRequest $request)
    {
        $this->poll->update($poll, $request->all());

        return redirect()->route('admin.polls.poll.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('polls::polls.title.polls')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Poll $poll
     * @return Response
     */
    public function destroy(Poll $poll)
    {
        $this->poll->destroy($poll);

        return redirect()->route('admin.polls.poll.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('polls::polls.title.polls')]));
    }
}
