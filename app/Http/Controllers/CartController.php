<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use Illuminate\Support\Facades\Cookie;
use App\Services\CartService;

class CartController extends Controller
{
    public function __construct(
        public CartService $cartService
    )
    {

    }

    public function index()
    {
        $cart = $this->cartService->getFromCookie();

        return view('carts.index')->with([
           'cart' => $cart,
        ]);
    }

}
