@extends($extends['view'])

@section($extends['section'])
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h1> {{ trans('roles::resource.create') }} </h1>
        </div>
    </div>
    {{ Form::open(['route' => 'roles.resource.store', 'method' => 'post']) }}
    <div class="row">
        <div class="col-sm-12">
            {{ Form::label( 'container', trans('roles::resource.container') ) }}
            {{ Form::text( 'container') }}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10 col-sm-push-2 text-right">
            {{ Form::submit( trans('roles::resource.create'), ['class' => 'btn btn-success'] ) }}
        </div>
        <div class="col-sm-2 col-sm-pull-10">
            <a href="{{ route('roles.resource.index') }}">{{ Form::Button( trans('roles::form.back'), ['class' => 'btn btn-primary']) }}</a>
        </div>
    </div>
    {{ Form::close() }}
</div>
@stop
