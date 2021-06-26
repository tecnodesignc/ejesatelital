<?php

namespace Modules\Location\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Location\Entities\Neighborhood;
use Modules\Location\Http\Requests\CreateNeighborhoodRequest;
use Modules\Location\Http\Requests\UpdateNeighborhoodRequest;
use Modules\Location\Repositories\NeighborhoodRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class NeighborhoodController extends AdminBaseController
{
    /**
     * @var NeighborhoodRepository
     */
    private $neighborhood;

    public function __construct(NeighborhoodRepository $neighborhood)
    {
        parent::__construct();

        $this->neighborhood = $neighborhood;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$neighborhoods = $this->neighborhood->all();

        return view('location::admin.neighborhoods.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('location::admin.neighborhoods.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateNeighborhoodRequest $request
     * @return Response
     */
    public function store(CreateNeighborhoodRequest $request)
    {
        $this->neighborhood->create($request->all());

        return redirect()->route('admin.location.neighborhood.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('location::neighborhoods.title.neighborhoods')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Neighborhood $neighborhood
     * @return Response
     */
    public function edit(Neighborhood $neighborhood)
    {
        return view('location::admin.neighborhoods.edit', compact('neighborhood'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Neighborhood $neighborhood
     * @param  UpdateNeighborhoodRequest $request
     * @return Response
     */
    public function update(Neighborhood $neighborhood, UpdateNeighborhoodRequest $request)
    {
        $this->neighborhood->update($neighborhood, $request->all());

        return redirect()->route('admin.location.neighborhood.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('location::neighborhoods.title.neighborhoods')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Neighborhood $neighborhood
     * @return Response
     */
    public function destroy(Neighborhood $neighborhood)
    {
        $this->neighborhood->destroy($neighborhood);

        return redirect()->route('admin.location.neighborhood.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('location::neighborhoods.title.neighborhoods')]));
    }
}
