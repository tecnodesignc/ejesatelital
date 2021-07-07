<?php

namespace Modules\Vehicle\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Vehicle\Entities\Vehicle;
use Modules\Vehicle\Http\Requests\CreateVehicleRequest;
use Modules\Vehicle\Http\Requests\UpdateVehicleRequest;
use Modules\Vehicle\Repositories\VehicleRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class VehicleController extends AdminBaseController
{
    /**
     * @var VehicleRepository
     */
    private $vehicle;

    public function __construct(VehicleRepository $vehicle)
    {
        parent::__construct();

        $this->vehicle = $vehicle;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$vehicles = $this->vehicle->all();

        return view('vehicle::admin.vehicles.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('vehicle::admin.vehicles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateVehicleRequest $request
     * @return Response
     */
    public function store(CreateVehicleRequest $request)
    {
        $this->vehicle->create($request->all());

        return redirect()->route('admin.vehicle.vehicle.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('vehicle::vehicles.title.vehicles')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Vehicle $vehicle
     * @return Response
     */
    public function edit(Vehicle $vehicle)
    {
        return view('vehicle::admin.vehicles.edit', compact('vehicle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Vehicle $vehicle
     * @param  UpdateVehicleRequest $request
     * @return Response
     */
    public function update(Vehicle $vehicle, UpdateVehicleRequest $request)
    {
        $this->vehicle->update($vehicle, $request->all());

        return redirect()->route('admin.vehicle.vehicle.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('vehicle::vehicles.title.vehicles')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Vehicle $vehicle
     * @return Response
     */
    public function destroy(Vehicle $vehicle)
    {
        $this->vehicle->destroy($vehicle);

        return redirect()->route('admin.vehicle.vehicle.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('vehicle::vehicles.title.vehicles')]));
    }
}
