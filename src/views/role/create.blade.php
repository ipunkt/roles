@extends($extends['view'])

@section($extends['section'])
    <div class="row">
        <div class="col-sm-12">
            <h1> {{ trans('roles::role.create') }} </h1>
        </div>
    </div>
    {{ Form::open(['route' => 'roles.role.store', 'method' => 'post']) }}
    <div class="row">
        <div class="col-sm-12">
            {{ Form::label('name', trans('roles::role.name')) }}
            {{ Form::text('name') }}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10 col-sm-push-2 text-right">
            {{ Form::submit(trans('roles::role.create'), ['class' => 'btn btn-success']) }}
        </div>
        <div class="col-sm-2 col-sm-pull-10">
            <a href="{{ route('roles.role.index') }}">{{ Form::Button( trans('roles::form.back'), ['class' => 'btn btn-primary'] ) }}</a>
        </div>
    </div>
    {{ Form::close() }}
@stop
