@extends($extends['view'])

@section($extends['section'])
    <table>
        <tr>
            <th>{{ trans('roles::role.name') }}</th>
        </tr>
    @foreach($roles as $role)
        <tr>
            <td><a href='{{ route('roles.role.show', $role->getId()) }}'>{{ $role->getName() }}</a></td>
        </tr>
    @endforeach
    </table>
    <a href="{{ route('roles.role.create') }}">{{ Form::button(trans('roles::role.create'), ['class' => 'btn btn-primary']) }}</a>
@stop
