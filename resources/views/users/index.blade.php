@extends('layouts.app')
@section('content')
<h2>Users Table</h2>
<table class="table table-striped">
    <tr>
        <th> ID </th>
        <th> Name </th>
        <th> Email </th>
        <th> Admin Since </th>
        <th> Actions </th>
    </tr>
    @empty($users)
        <tr>
            <td colspan="6"> Table is empty </td>
        </tr>
    @endempty
    @foreach($users as $user)
        <tr>
            <td> {{ $user->id  }} </td>
            <td> {{ $user->name  }} </td>
            <td> {{ $user->email  }} </td>
            <td> {{ optional($user->admin_since)->diffForHumans() ?? 'Never'}} </td>
            <td>
                <form class="d-inline" action="{{ route('users.admin.toggle', $user->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-link">{{  $user->isAdmin() ? 'Remove' : 'Make' }} Admin </button>
                </form>
            </td>
        </tr>
    @endforeach
</table>
@endsection
