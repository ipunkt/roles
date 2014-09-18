@extends($extends['view'])

@section($extends['script'])
<script src="/packages/ipunkt/roles/edit.js"></script>
@stop

@section($extends['section'])
<div class="panel-group" id="edit-page">

{{-- Edit/Delete Role collapsible --}}
<div class="panel panel-default">

    <div class="panel-heading">
        <h1 class="panel-title">
            <a data-toggle="collapse" data-parent="#edit-page" href="#collapseEdit">
                {{ trans('roles::role.edit') }}
            </a>
        </h1>
    </div>

    <div id="collapseEdit" class="panel-collapse collapse {{ $edit_open }} ">

        {{-- Status messages/errors --}}
        @if ( $errors->has('name') )
        <div class="col-sm-12">
            <div class="text-danger">
                {{ $errors->first('name') }}
            </div>
        </div>
        @endif
        @if ( Session::has('name') )
        <div class="col-sm-12">
            <div class="text-success">
                {{ Session::get('name') }}
            </div>
        </div>
        @endif

        {{ Form::open(['route' => ['roles.role.update', $role->getId()], 'method' => 'put']) }}
        <div class="row">
            <div class="col-sm-12">
                {{ Form::label('name', trans('roles::role.name')) }}
                {{ Form::text('name', $role->getName()) }}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10 col-sm-push-2 text-right">
                {{ Form::submit( trans('roles::role.save'), ['class' => 'btn btn-success']) }}
            </div>
            {{ Form::close() }}
            <div class="col-sm-2 col-sm-pull-10">
                {{ Form::open(['route' => ['roles.role.destroy', $role->getId()], 'method' => 'delete']) }}
                {{ Form::submit( trans('roles::role.delete'), ['class' => 'btn btn-danger'] ) }}
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

{{-- Add/Remove/Edit role permission collapsible --}}
<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title">
            <a data-toggle="collapse" data-parent="#edit-page" href="#collapseHasPrivilege">
                {{ trans('roles::role.privilege') }}
            </a>
        </h1>
    </div>
    <div id="collapseHasPrivilege" class="panel-collapse collapse {{ $privilege_open }}">
        <div class="row">
            <div class="col-sm-12">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <h2>{{ trans('roles::role.has privilege') }}</h2>
            </div>
        </div>

        {{-- Status messages/errors --}}
        @if ( $errors->has('permission') )
        <div class="row">
            <div class="col-sm-12">
                <span class="text-danger">
                    {{ $errors->first('permission') }}
                </span>
            </div>
        </div>
        @endif
        @if ( Session::has('permission') )
        <div class="row">
            <div class="col-sm-12">
                <span class="text-success">
                    {{ Session::get('permission') }}
                </span>
            </div>
        </div>
        @endif

        <div class="row">
            <div class="col-sm-12">

                <div class="panel-group" id="edit-permission">
                    @if ($errors->has('permission edit'))
                    <span class="text-danger"> {{ $errors->has('permission edit') }}</span>
                    @elseif (Session::has('permission edit'))
                    <span class="text-success"> {{ Session::get('permission edit') }}</span>
                    @endif

                    <?PHP $edit_count = 0 ?>
                    @foreach($permission_categories as $name => $category)
                    {{-- PermissionCategory collapsible --}}
                    <div class="panel panel-default">

                        <div class="panel-heading">
                            <h1 class="panel-title">
                                <a data-toggle="collapse" data-parent="#edit-permission" href="#collapse_edit_{{ $edit_count }}">
                                    {{ $name }}
                                </a>
                            </h1>
                        </div>

                        <div id="collapse_edit_{{ $edit_count++ }}" class="panel-collapse collapse {{ $permission_container[$name] }}">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th> {{ trans('roles::permission.representation') }} </th>
                                    <th> {{ trans('roles::permission.specific to id') }} </th>
                                    <th> {{ trans('roles::permission.permission') }} </th>
                                    <th> {{ trans('roles::permission.delete') }} </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($category as $permission)
                                <tr>
                                    <td>
                                        {{ $permission->getStringRepresentation() }}
                                    </td>
                                    <td>
                                        {{ Form::open( ['route' => ['roles.permission.update', $role->getId(), $permission->getId()], 'method' => 'put'])  }}
                                        <div class="container-fluid">
                                            <div class="col-xs-4 text-right">
                                                {{ Form::label('specific_to_id', trans('roles::permission.id all')) }}
                                                {{ Form::radio('specific_to_id', 'all', is_null($permission->getRow()), ['class' => 'radiosubmit']) }}
                                            </div>
                                            <div class="col-xs-7 text-right">
                                                {{ Form::text('specific_id', $permission->getRow(), ['class' => 'text-right']) }}
                                            </div>
                                            <div class="col-xs-1">
                                                {{ Form::radio('specific_to_id', 'specific', !is_null($permission->getRow()), ['class' => 'radiosubmit']) }}
                                            </div>
                                        </div>
                                        {{ Form::close() }}
                                    </td>
                                    <td>
                                        {{ Form::open( ['route' => ['roles.permission.update', $role->getId(), $permission->getId()], 'method' => 'put'])  }}
                                        {{ Form::label('permission', trans('roles::permission.grants')) }}
                                        {{ Form::radio('permission', 1, $permission->grantsPermission(), ['class' => 'radiosubmit']) }}
                                        {{ Form::label('permission', trans('roles::permission.denies')) }}
                                        {{ Form::radio('permission', -1, $permission->deniesPermission(), ['class' => 'radiosubmit']) }}
                                        {{ Form::close() }}
                                    </td>
                                    <td>
                                        {{ Form::open([ 'route' => ['roles.permission.destroy', $role->getId(), $permission->getId() ], 'method' => 'delete' ]) }}
                                        {{ Form::Submit(trans('roles::permission.delete'), ['class' => 'btn btn-danger']) }}
                                        {{ Form::close() }}
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <h2>{{ trans('roles::role.add privilege') }}</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel-group" id="accordion">
                    <div class="panel panel-default">
                        <?PHP $count=0 ?>
                        @foreach($privileges as $privilege)
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $count }}">
                                    {{ $privilege->getName()}}
                                </a>
                            </h4>
                        </div>
                        <div id="collapse{{ $count++ }}" class="panel-collapse collapse {{ $permission_add_container[$privilege->getName()] }}">
                            <div class="panel-body">
                                <table class="table table-hover">
                                    <tr>
                                        <th>{{ trans('roles::privilege.action') }}</th>
                                    </tr>
                                    @foreach($privilege->getActions() as $action)
                                    <tr>
                                        <td>{{ $action->getName() }}</td>
                                        <td class="text-right">
                                            {{ Form::open(['route' => ['roles.permission.store', $role->getId(), $privilege->getId(), $action->getId()], 'method' => 'post']) }}
                                            {{ Form::submit(trans('roles::role.add privilege'), ['class' => 'btn btn-success'] ) }}
                                            {{ Form::close() }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-1">
        <a href="{{ route('roles.role.show', $role->getId()) }}">{{ Form::button( trans('roles::form.back'), ['class' => 'btn btn-primary'] ) }}</a>
    </div>
</div>
@stop

