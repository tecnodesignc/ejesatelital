@extends('layouts.master')

@section('content-header')
<h4>
    {{ trans('user::users.title.users') }}
</h4>
<ol class="breadcrumb m-0">
    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
    <li class="breadcrumb-item active">{{ trans('user::users.breadcrumb.users') }}</li>
</ol>
    <div class="col-sm-6">
        <div class="float-end d-none d-sm-block">
            <a href="{{ route('admin.user.user.create') }}" class="btn btn-success"> {{ trans('user::users.button.new-user') }}</a>
        </div>
    </div>
    {{dd('sdfdsfsdf')}}
@stop

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table class="data-table table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>{{ trans('user::users.table.first-name') }}</th>
                            <th>{{ trans('user::users.table.last-name') }}</th>
                            <th>{{ trans('user::users.table.email') }}</th>
                            <th>{{ trans('user::users.table.created-at') }}</th>
                            <th data-sortable="false">{{ trans('user::users.table.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (isset($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td>
                                    <a href="{{ route('admin.user.user.edit', [$user->id]) }}">
                                        {{ $user->id }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.user.user.edit', [$user->id]) }}">
                                        {{ $user->first_name }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.user.user.edit', [$user->id]) }}">
                                        {{ $user->last_name }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.user.user.edit', [$user->id]) }}">
                                        {{ $user->email }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.user.user.edit', [$user->id]) }}">
                                        {{ $user->created_at }}
                                    </a>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.user.user.edit', [$user->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                        <?php if ($user->id != $currentUser->id): ?>
                                            <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.user.user.destroy', [$user->id]) }}"><i class="fa fa-trash"></i></button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>{{ trans('user::users.table.first-name') }}</th>
                            <th>{{ trans('user::users.table.last-name') }}</th>
                            <th>{{ trans('user::users.table.email') }}</th>
                            <th>{{ trans('user::users.table.created-at') }}</th>
                            <th>{{ trans('user::users.table.actions') }}</th>
                        </tr>
                    </tfoot>
                </table>
            <!-- /.box-body -->
            </div>
        <!-- /.box -->
    </div>
<!-- /.col (MAIN) -->
</div>
</div>

@include('core::partials.delete-modal')
@stop

@push('js-stack')
<?php $locale = App::getLocale(); ?>
<script type="text/javascript">
    $( document ).ready(function() {
        $(document).keypressAction({
            actions: [
                { key: 'c', route: "<?= route('admin.user.user.create') ?>" }
            ]
        });
    });
    $(function () {
        $('.data-table').dataTable({
            "paginate": true,
            "lengthChange": true,
            "filter": true,
            "sort": true,
            "info": true,
            "autoWidth": true,
            "order": [[ 0, "desc" ]],
            "language": {
                "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
            }
        });
    });
</script>
@endpush
