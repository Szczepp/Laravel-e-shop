@extends('layouts.app')
@section('content')
<h1> Payment details </h1>
<h4 class="text-center"><strong>Grand Total: ${{ $order->total }}</strong></h4>

<div class="text-center mb-3">
    <form
        class="d-inline"
        method="POST"
        action="{{ route('orders.payments.store', ['order' => $order->id])}}"
    >
        @csrf
        <button class="btn btn-success" type="submit"> Pay </button>
    </form>
</div>
@endsection
