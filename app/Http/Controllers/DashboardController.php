<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $packages = Package::all();
        return view('pages.index', compact('packages'));
    }

    public function showProduct($id)
    {
        $package = Package::with('products')->find($id);

        return view('pages.show-package', compact('package'));
    }
}