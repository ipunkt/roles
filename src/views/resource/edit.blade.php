@extends($extends['view'])

@section($extends['section'])
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h1> {{ trans('roles::resource.edit') }} </h1>
        </div>
    </div>
    {{ Form::open(['route' => ['roles.resource.update', $resource->getId()], 'method' => 'put']) }}
    <div class="row">
        <div class="col-sm-12">
            {{ Form::label( 'container', trans('roles::resource.container') ) }}
            {{ Form::text( 'container', $resource->containerName()) }}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-1 col-sm-push-11">
            {{ Form::submit(trans('roles::form.save'), ['class' => 'btn btn-success']) }}
        </div>
        <div class="col-sm-2 col-sm-push-4">
            {{ Form::open(['route' => ['roles.resource.destroy', $resource->getId()], 'method' => 'delete']) }}
            {{ Form::submit(trans('roles::form.delete'), ['class' => 'btn btn-danger']) }}
            {{ Form::close() }}
        </div>
        <div class="col-sm-1 col-sm-pull-3">
            <a href="{{ route('roles.resource.show', $resource->getId()) }} ">{{ Form::button(trans('roles::form.back'), ['class' => 'btn btn-primary'] ) }}</a>
        </div>
    </div>
    <div class="row">
        {{ Form::close() }}
    </div>
    <div class="row">
        <div class="col-sm-12">
            <h2> {{ trans('roles::resource.actions') }}</h2>
            <table class="table table-hover">
                <tr>
                    <th>{{ trans('roles::resource.action') }}</th>
                    <th class="text-right">{{ trans('roles::resource.delete action') }} </th>
                </tr>
                @foreach( $resource->actionList() as $action )
                <tr>
                    <td> {{{ $action->name() }}} </td>
                    <td class="text-right">
                        {{ Form::open(['route' => ['roles.resource.destroy_action', $resource->getId(), $action->getId() ], 'method' => 'post']) }}
                        {{ Form::submit(trans('roles::resource.delete action'), ['class' => 'btn btn-danger']) }}
                        {{ Form::close() }}
                    </td>
                </tr>
                @endforeach
            </table>
            <h3>{{ trans('roles::resource.add action') }}</h3>

            {{ Form::open(['route' => ['roles.resource.store_action', $resource->getId()], 'method' => 'post']) }}
            <div class="row">
                <div class="col-sm-12">
                    {{ Form::label('name', trans('roles::action.name')) }}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-10">
                    {{ Form::text('name') }}
                </div>
                <div class="col-sm-2">
                    {{ Form::submit(trans('roles::resource.add action'), ['class' => 'btn btn-success']) }} </td>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@stop
