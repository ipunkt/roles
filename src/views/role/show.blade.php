@extends($extends['view'])

@section($extends['section'])
    <h1>{{ trans('roles::role.show') }}</h1>
    <div class="row">
        <div class="col-sm-12">
            {{ Form::label('name', trans('roles::role.name')) }}
            {{ Form::text('name', $role->getName(), ['disabled' => 'disabled']) }}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-11 col-sm-push-1 text-right">
            <a href="{{ route('roles.role.edit', $role->getId()) }}">{{ Form::button(trans('roles::role.edit'), ['class' => 'btn btn-primary']) }}</a>
        </div>
        <div class="col-sm-1 col-sm-pull-11">
            <a href="{{ route('roles.role.index') }}">{{ Form::button(trans('roles::form.back'), ['class' => 'btn btn-primary']) }}</a>
        </div>
    </div>
@stop
