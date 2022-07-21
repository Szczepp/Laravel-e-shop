@extends('layouts.app')
@section('content')
<h2>Products Table</h2>
<a class="btn btn-success mb-3" href="{{ route('products.create') }}"> Create </a>
<table class="table table-striped">
    <tr>
        <th> ID </th>
        <th> Name </th>
        <th> Description </th>
        <th> Price </th>
        <th> Stock </th>
        <th> Status </th>
        <th> Actions </th>
    </tr>
    @empty($products)
        <tr>
            <td colspan="6"> Table is empty </td>
        </tr>
    @endempty
    @foreach($products as $product)
        <tr>
            <td> {{ $product->id  }} </td>
            <td> {{ $product->title  }} </td>
            <td> {{ $product->description  }} </td>
            <td> {{ $product->price  }} </td>
            <td> {{ $product->stock  }} </td>
            <td> {{ $product->status  }}
            <td>
                <a class="btn btn-link" href="{{ route('products.show', $product->id) }}"> Show </a>
                <a class="btn btn-link" href="{{ route('products.edit', $product->id) }}"> Edit </a>
                <form class="d-inline" action="{{ route('products.destroy', $product->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-link"> Delete </button>
                </form>
            </td>
        </tr>
    @endforeach
</table>
@endsection
