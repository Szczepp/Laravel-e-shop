@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> Admin panel </div>

                <div class="card-body">
                    <a class="list-group item" href="{{ route('products.index') }}">
                        Manage Products
                    </a>
                    <a class="list-group item" href="{{ route('users.index') }}">
                        Manage Users
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
