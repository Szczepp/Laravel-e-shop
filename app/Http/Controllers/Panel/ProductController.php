<?php

namespace App\Http\Controllers\Panel;

use App\Http\Requests\ProductRequest;
use App\Models\PanelProduct;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Scopes\AvailableScope;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        $products = PanelProduct::without('images')->get();

        return view('products.index')->with([
            'products'=>$products,
        ]);
    }

    public function show(PanelProduct $product)
    {

        return view('products.show')->with([
            'product'=> $product,
        ]);
    }

    public function edit(PanelProduct $product)
    {

        return view('products.edit')->with([
            'product' => $product,
        ]);
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(ProductRequest $request)
    {
        $product = PanelProduct::create($request->validated());

        foreach ($request->images as $image) {
            $product->images()->create([
                'path' =>  'images/' . $image->store('products', 'images')
            ]);
        }

        return redirect()
            ->route('products.index')
            ->withSuccess("New product with id {$product->id} has been created");
    }

    public function update(ProductRequest $request, PanelProduct $product)
    {
        $product->update($request->validated());

        if ($request->hasFile('images')) {
            foreach ($product->images as $image) {

                $path = storage_path("app/public/{$image->path}");
                File::delete($path);
                $image->delete();
            }
            foreach ($request->images as $image) {
                $product->images()->create([
                    'path' =>  'images/' . $image->store('products', 'images')
                ]);
            }
        }

        return redirect()
            ->route('products.index')
            ->withSuccess("Product with id {$product->id} has been updated");
    }

    public function destroy(PanelProduct $product)
    {
        $product->delete();


        return redirect()
            ->route('products.index')
            ->withSuccess("Product with id {$product->id} has been removed");
    }
}