<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = Product::with(['user:id,user_name,full_name', 'images', 'auctions', 'reviews'])
            ->withAvg('reviews', 'rating');

        //Filter by title
        if ($request->filled('search')) {
            $query->title($request->get('search'));
        }

        //Filter by category

        if ($request->filled('category')) {
            $scope = Str::studly(str_replace('/', '', $request->category));

            if (method_exists(Product::class, 'scope' . $scope)) {
                $query->{$scope}();
            }
        } elseif ($request->filled('categories') && is_array($request->categories) && count($request->categories) > 0) {
            $query->whereIn('category', $request->categories);
        }

        //Filter by price
        if ($request->filled('minPrice')) {
            $query->where('price', '>=', $request->minPrice);
        } else {
            $query->where('price', '>=', 0);
        }

        if ($request->filled('maxPrice')) {
            $query->where('price', '<=', $request->maxPrice);
        } else {
            $query->where('price', '<=', 50000);
        }

        //Filter by location
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }


        // Filter by listing type(Auction/Buy)
        if ($request->filled('listingType') && $request->listingType !== 'all') {
            if ($request->listingType === 'auction') {
                $query->has('auctions');
            } elseif ($request->listingType === 'buy_now') {
                $query->doesntHave('auctions');
            }
        }

        // If no filters applied, show most rated
        if (
            !$request->filled('search') && !$request->filled('category') &&
            !$request->filled('categories') && !$request->filled('minPrice') &&
            !$request->filled('maxPrice') && !$request->filled('location') &&
            !$request->filled('listingType')
        ) {
            $query->mostRated()->limit(8);
        }

        return inertia(
            'Product/Index',
            [
                'products' => $query->get(),
                'search' => $request->get('search'),
                'category' => $request->get('category')
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Product/Create', [
            'authUser' => Auth::user()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validCategories = ['Electronics', 'Clothing', 'Furniture', 'Laptops/Phones', 'Books', 'Toys', 'Sport', 'Beauty', 'Other'];

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|in:' . implode(',', $validCategories),
            'location' => 'required|string',
            'price' => 'required|numeric',
            'images.*' => 'image|max:2048'
        ]);

        $validated["user_id"] = Auth::user()->id;
        $validated["image_path"] = 'https://via.placeholder.com/150';

        $product = Product::create($validated);
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('products', 'public');
                $product->images()->create([
                    'file_name' => $path
                ]);
            }
        }
        return redirect()->route('products.index')
            ->with('success', 'Product was added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return inertia('Product/Show', [
            'product' => $product->load([
                'user:id,user_name,full_name',
                'reviews' => function ($query) {
                    $query->latest()->with(['user:id,user_name,full_name']);
                }
            ])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return inertia(
            'Product/Edit',
            [
                'product' => $product
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validCategories = ['Electronics', 'Clothing', 'Furniture', 'Laptops/Phones', 'Books', 'Toys', 'Sport', 'Beauty', 'Other'];

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|in:' . implode(',', $validCategories),
            'price' => 'required|numeric',

        ]);

        $validated["user_id"] = 1;
        $validated["image_path"] = 'https://via.placeholder.com/150';

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Product was edited successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', "Product deleted!");
    }
}
