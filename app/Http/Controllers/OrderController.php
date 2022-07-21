<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Services\CartService;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function __construct(
        public CartService $cartService
    )
    {
        $this->middleware('auth');
    }

    public function create()
    {
        $cart = $this->cartService->getFromCookie();

        if (! isset($cart) || $cart->products->isEmpty()) {
            return redirect()
                ->back()
                ->withErrors('Your cart is empty');
        }

            return view('orders.create')->with(['cart' => $cart]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOrderRequest  $request
     */
    public function store(StoreOrderRequest $request)
    {
        return DB::transaction(function () use($request) {
            $user = $request->user();
            $order = $user->orders()->create([
                'status' => 'pending'
            ]);
            $cart = $this->cartService->getFromCookie();

            $cartProductsWithQuantity = $cart
                ->products
                ->mapWithKeys(function ($product) {
                    $quantity = $product->pivot->quantity;

                    if ($product->stock < $quantity) {
                        throw ValidationException::withMessages([
                            'cart' => "There is not enough stock for the quantity you required ({$product->title})"
                        ]);
                    }
                    $product->decrement('stock', $quantity);
                    $element[$product->id] = ['quantity' => $product->pivot->quantity];

                    return $element;
                });
            $order->products()->attach($cartProductsWithQuantity->toArray());

            return redirect()->route('orders.payments.create', ['order' => $order->id]);
        }, 5);
    }


}
