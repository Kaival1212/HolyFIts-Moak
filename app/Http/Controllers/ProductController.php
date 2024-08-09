<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Collection;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Collection $collection ,Product $product , Request $request)
    {
        $varientRequest = $request->query('varientId');
        $Varients = $product->Varients->groupBy('name')->toArray();
        $varient = null;
        $product->CheapestVarient = $product->getCheapestVarient();

        if($varientRequest != null){
            $varient = $product->Varients->where('id', $varientRequest)->first();
        }

        return Inertia::render('Product',["product"=>$product , 'collection'=>$collection ,'selectedVarient'=>$varient, 'varients'=>$Varients]);
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
    public function store(StoreProductRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
