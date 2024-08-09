<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCollectionRequest;
use App\Http\Requests\UpdateCollectionRequest;
use App\Models\Collection;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Collection $slug, Request $request)
    {
        $query = $slug->products()->with('Varients');

        // Apply search filter
        if ($request->has('search')) {
            $searchQuery = $request->input('search');
            $query->where('name', 'like', "%{$searchQuery}%");
        }

        // Apply sorting
        if ($request->has('sort-price')) {
            $sortDirection = $request->input('sort-price');
            $query->orderBy('cheapest_variant_price', $sortDirection);
        }

        // Execute the query and get the results
        $products = $query->get()->map(function ($product) {
            $product->cheapestVariantPrice = $product->getCheapestVarient();
            return $product;
        });

        return Inertia::render('Collection', [
            'productsList' => $products,
            'collection' => $slug,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCollectionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Collection $collection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Collection $collection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCollectionRequest $request, Collection $collection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Collection $collection)
    {
        //
    }
}
