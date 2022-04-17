<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Package;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        $categories = Category::all();
        return view('pages.master.product.index', compact('products', 'categories'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:products|max:255',
            'category_id' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $image = $request->file('photo');
        $imageName = $request->name . '_' . time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);

        Product::create([
            'name' => $request->name,
            'id_category' => $request->category_id,
            'photo_path' => 'images/' . $imageName,
        ]);

        return redirect()->route('product.index')->with('success', 'Product has been created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('pages.master.product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            unlink(public_path($product->photo_path));
            $image = $request->file('photo');
            $imageName = $request->name . '_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $product->photo_path = 'images/' . $imageName;
        }

        $product->update([
            'name' => $request->name,
            'id_category' => $request->category_id,
        ]);

        return redirect()->route('product.index')->with('success', 'Product has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        unlink(public_path($product->photo_path));
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product has been deleted');
    }
}