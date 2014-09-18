@extends($extends['view'])

@section($extends['section'])
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h1> {{ trans('roles::resource.show') }} </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            {{ Form::label( 'container', trans('roles::resource.container') ) }}
            {{ Form::text( 'container', $resource->containerName(), ['disabled' => 'disabled']) }}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <h2> {{ trans('roles::resource.actions') }}</h2>
            <ul>
                @foreach( $resource->actionList() as $action )
                    <li> {{{ $action->name() }}}</li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2 col-sm-offset-9 col-sm-push-1">
            <a href="{{ route('roles.resource.edit', $resource->getId()) }} ">{{ Form::button(trans('roles::resource.edit'), ['class' => 'btn btn-primary'] ) }}</a>
        </div>
        <div class="col-sm-1 col-sm-pull-11">
            <a href="{{ route('roles.resource.index') }} ">{{ Form::button(trans('roles::form.back'), ['class' => 'btn btn-primary'] ) }}</a>
        </div>
    </div>
@stop
