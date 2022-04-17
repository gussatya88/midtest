<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Product;
use Illuminate\Http\Request;

class PackageResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Package::with('products')->get();
        // $products = Product::all();
        return view('pages.master.package.index', compact('packages'));
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
            'name' => 'required',
            'end_price' => 'required|numeric|min:0',
            'normal_price' => 'required|numeric|min:0|gt:end_price',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $image = $request->file('photo');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('package-images'), $imageName);

        $package = Package::create([
            'name' => $request->name,
            'normal_price' => $request->normal_price,
            'end_price' => $request->end_price,
            'photo_path' => 'package-images/' . $imageName,
        ]);

        $package->products()->attach($request->product_id);

        return redirect()->route('package.index')->with('success', 'Package has been created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package)
    {
        return view('pages.master.package.edit', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $package)
    {
        $request->validate([
            'end_price' => 'required|numeric',
            'normal_price' => 'required|numeric',
            'photo' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            unlink(public_path($package->photo_path));
            $image = $request->file('photo');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('package-images'), $imageName);
            $package->photo_path = 'package-images/' . $imageName;
        }

        $package->update([
            'normal_price' => $request->normal_price,
            'end_price' => $request->end_price,
        ]);

        return redirect()->route('package.index')->with('success', 'Package has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        unlink(public_path($package->photo_path));
        $package->products()->detach();
        $package->delete();
        return redirect()->route('package.index')->with('success', 'Package has been deleted');
    }

    public function manageProduct(Package $package)
    {
        $products = Product::all();
        return view('pages.master.package.manage-product', compact('package', 'products'));
    }

    public function viewAddProductToPackage(Package $package)
    {
        $products = Product::with('packages')->whereDoesntHave('packages', function ($query) use ($package) {
            $query->where('id_package', $package->id);
        })->get();
        return view('pages.master.package.add-product', compact('package', 'products'));
    }

    public function addProductToPackage(Request $request, Package $package)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required',
        ]);

        $package->products()->attach($request->product_id, [
            'quantity' => $request->quantity,
        ]);


        return redirect()->back()->with('success', 'Product has been added to package');
    }

    public function deleteProductFromPackage(Request $request, Package $package)
    {
        // dd($request->all());
        $package->products()->detach($request->id_product);

        return redirect()->back()->with('success', 'Product has been deleted from package');
    }
}