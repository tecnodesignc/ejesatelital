@extends('layouts.master')

@section('content-header')
    <h4>
        {{ trans('company::accounts.title.accounts') }}
    </h4>
    <ol class="breadcrumb m-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}"><i
                    class="fas fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="breadcrumb-item active">{{ trans('company::accounts.title.accounts') }}</li>
    </ol>
    <div class="col-sm-6">
        <div class="float-end d-none d-sm-block">
            <a href="{{ route('admin.company.account.create') }}"
               class="btn btn-success"> {{ trans('company::accounts.button.create account') }}</a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="datatable" class="table table-bordered dt-responsive nowrap"
                           style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>{{ trans('core::core.table.created at') }}</th>
                            <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (isset($accounts))
                            @foreach ($accounts as $account)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.company.account.edit', [$account->id]) }}">
                                            {{ $account->created_at }}
                                        </a>
                                    </td>
                                    <td>

                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.company.account.edit', [$account->id]) }}"
                                               class="btn btn-default btn-flat"><i class="fas fa-pencil"></i></a>
                                            <button class="btn btn-danger btn-flat" data-toggle="modal"
                                                    data-target="#modal-delete-confirmation"
                                                    data-action-target="{{ route('admin.company.account.destroy', [$account->id]) }}">
                                                <i class="fas fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>{{ trans('core::core.table.created at') }}</th>
                            <th>{{ trans('core::core.table.actions') }}</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>{{ trans('core::core.table.created at') }}</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($accounts)): ?>
                            <?php foreach ($accounts as $account): ?>
                            <tr>
                                <td>
                                    <a href="{{ route('admin.company.account.edit', [$account->id]) }}">
                                        {{ $account->created_at }}
                                    </a>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.company.account.edit', [$account->id]) }}"
                                           class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger btn-flat" data-toggle="modal"
                                                data-target="#modal-delete-confirmation"
                                                data-action-target="{{ route('admin.company.account.destroy', [$account->id]) }}">
                                            <i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>{{ trans('core::core.table.created at') }}</th>
                                <th>{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </tfoot>
                        </table>
                        <!-- /.box-body -->
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
    @include('core::partials.delete-modal')
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('company::accounts.title.create account') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).keypressAction({
                actions: [
                    {key: 'c', route: "<?= route('admin.company.account.create') ?>"}
                ]
            });
        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".data-table").DataTable(), $("#datatable-buttons").DataTable({
                lengthChange: !1,
                buttons: ["copy", "excel", "pdf", "colvis"]
            }).buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)"), $(".dataTables_length select").addClass("form-select form-select-sm")
        });
    </script>
@endpush
