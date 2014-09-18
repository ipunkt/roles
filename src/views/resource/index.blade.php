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
                <ul>
        @foreach($resources as $resource)
                    <li>
                        <a href="{{ route('roles.resource.show', $resource->getId()) }} ">{{{ $resource->containerName() }}} </a>
                    </li>
        @endforeach
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-1">
                <a href=" {{ route('roles.resource.create') }} ">{{ Form::button( trans('roles::resource.create'), ['class' => 'btn btn-primary']) }}</a>
            </div>
        </div>
    </div>
@stop
