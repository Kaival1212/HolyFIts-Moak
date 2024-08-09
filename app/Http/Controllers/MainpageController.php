<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Collection;
use App\Models\Offer;
use App\Models\Product;
use Inertia\Inertia;

class MainpageController extends Controller
{
    public function show()
    {

        $offers = Offer::where('is_active', true)->get();
        $bannerData = Banner::where('is_active', true)->get();

        $collectionsProducts = Collection::all()->map(function ($collection) {

            $products = $collection->Products->map(function ($product) {
                $cheapestVariantPrice = $product->getCheapestVarient();
                $productArray = $product->toArray();
                $productArray['cheapestVariantPrice'] = $cheapestVariantPrice;
                return $productArray;
            });

            return [
                'collection' => $collection,
                // 'collectionName' => $collection->name,
                // 'collectionSlug' => $collection->slug,
                 "products" => $products->toArray(),

            ];
        });

        return Inertia::render('Main', ["offers" => $offers, "bannerData" => $bannerData, 'collectionsProducts' => $collectionsProducts]);
    }
}
