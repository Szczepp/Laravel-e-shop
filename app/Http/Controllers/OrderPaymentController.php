<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Services\CartService;
use Illuminate\Support\Facades\DB;

class OrderPaymentController extends Controller
{
    public function __construct(
        public CartService $cartService,
    )
    {
        $this->middleware('auth');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Order  $order
     */
    public function create(Order $order)
    {
        return view('payments.create')->with([
            'order' => $order
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Order $order)
    {
        return DB::transaction(function () use($request, $order) {
            //implement payment service
            $this->cartService->getFromCookie()->products()->detach();
            $order->payment()->create([
                'amount' => $order->total,
                'paid_at' => now(),
            ]);
            $order->status = 'paid';
            $order->save();

            return redirect()
                ->route('main')
                ->withSuccess("Thanks! We received your \${$order->total} payment.");
        });
    }
}
