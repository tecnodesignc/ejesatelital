<?php

namespace Modules\Location\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Location\Entities\Country;
use Modules\Location\Http\Requests\CreateCountryRequest;
use Modules\Location\Http\Requests\UpdateCountryRequest;
use Modules\Location\Repositories\CountryRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class CountryController extends AdminBaseController
{
    /**
     * @var CountryRepository
     */
    private $country;

    public function __construct(CountryRepository $country)
    {
        parent::__construct();

        $this->country = $country;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$countries = $this->country->all();

        return view('location::admin.countries.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('location::admin.countries.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCountryRequest $request
     * @return Response
     */
    public function store(CreateCountryRequest $request)
    {
        $this->country->create($request->all());

        return redirect()->route('admin.location.country.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('location::countries.title.countries')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Country $country
     * @return Response
     */
    public function edit(Country $country)
    {
        return view('location::admin.countries.edit', compact('country'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Country $country
     * @param  UpdateCountryRequest $request
     * @return Response
     */
    public function update(Country $country, UpdateCountryRequest $request)
    {
        $this->country->update($country, $request->all());

        return redirect()->route('admin.location.country.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('location::countries.title.countries')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Country $country
     * @return Response
     */
    public function destroy(Country $country)
    {
        $this->country->destroy($country);

        return redirect()->route('admin.location.country.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('location::countries.title.countries')]));
    }
}
