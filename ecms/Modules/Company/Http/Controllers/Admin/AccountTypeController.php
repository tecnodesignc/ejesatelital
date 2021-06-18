<?php

namespace Modules\Company\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Company\Entities\AccountType;
use Modules\Company\Http\Requests\CreateAccountTypeRequest;
use Modules\Company\Http\Requests\UpdateAccountTypeRequest;
use Modules\Company\Repositories\AccountTypeRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class AccountTypeController extends AdminBaseController
{
    /**
     * @var AccountTypeRepository
     */
    private $accounttype;

    public function __construct(AccountTypeRepository $accounttype)
    {
        parent::__construct();

        $this->accounttype = $accounttype;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $accounttypes = $this->accounttype->all();

        return view('company::admin.accounttypes.index', compact('accounttypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('company::admin.accounttypes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateAccountTypeRequest $request
     * @return Response
     */
    public function store(CreateAccountTypeRequest $request)
    {
        $this->accounttype->create($request->all());

        return redirect()->route('admin.company.accounttype.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('company::accounttypes.title.accounttypes')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  AccountType $accounttype
     * @return Response
     */
    public function edit(AccountType $accounttype)
    {
        return view('company::admin.accounttypes.edit', compact('accounttype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AccountType $accounttype
     * @param  UpdateAccountTypeRequest $request
     * @return Response
     */
    public function update(AccountType $accounttype, UpdateAccountTypeRequest $request)
    {
        $this->accounttype->update($accounttype, $request->all());

        return redirect()->route('admin.company.accounttype.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('company::accounttypes.title.accounttypes')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  AccountType $accounttype
     * @return Response
     */
    public function destroy(AccountType $accounttype)
    {
        $this->accounttype->destroy($accounttype);

        return redirect()->route('admin.company.accounttype.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('company::accounttypes.title.accounttypes')]));
    }
}
