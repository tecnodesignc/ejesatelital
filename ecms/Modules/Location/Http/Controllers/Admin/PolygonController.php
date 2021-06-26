<?php

namespace Modules\Location\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Location\Entities\Polygon;
use Modules\Location\Http\Requests\CreatePolygonRequest;
use Modules\Location\Http\Requests\UpdatePolygonRequest;
use Modules\Location\Repositories\PolygonRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class PolygonController extends AdminBaseController
{
    /**
     * @var PolygonRepository
     */
    private $polygon;

    public function __construct(PolygonRepository $polygon)
    {
        parent::__construct();

        $this->polygon = $polygon;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$polygons = $this->polygon->all();

        return view('location::admin.polygons.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('location::admin.polygons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePolygonRequest $request
     * @return Response
     */
    public function store(CreatePolygonRequest $request)
    {
        $this->polygon->create($request->all());

        return redirect()->route('admin.location.polygon.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('location::polygons.title.polygons')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Polygon $polygon
     * @return Response
     */
    public function edit(Polygon $polygon)
    {
        return view('location::admin.polygons.edit', compact('polygon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Polygon $polygon
     * @param  UpdatePolygonRequest $request
     * @return Response
     */
    public function update(Polygon $polygon, UpdatePolygonRequest $request)
    {
        $this->polygon->update($polygon, $request->all());

        return redirect()->route('admin.location.polygon.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('location::polygons.title.polygons')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Polygon $polygon
     * @return Response
     */
    public function destroy(Polygon $polygon)
    {
        $this->polygon->destroy($polygon);

        return redirect()->route('admin.location.polygon.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('location::polygons.title.polygons')]));
    }
}
