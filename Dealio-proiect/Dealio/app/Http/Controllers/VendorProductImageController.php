<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class VendorProductImageController extends Controller
{
    public function create(Product $product)
    {
        return inertia(
            'Vendor/ProductImage/Create',
            ['product' => $product]
        );
    }

    public function store(Product $product, Request $request)
    {
        //dd($request->all(), $request->file('images'));

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('images', 'public');
                $product->images()->save(new ProductImage(['file_name' => $path]));
            }
            return redirect()->back()->with('success', 'Images uploaded successfully');
        }
    }
}
