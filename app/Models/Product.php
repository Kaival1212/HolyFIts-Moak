<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $guarded=[];

    protected $casts = [
        'tags' => 'array', // Automatically casts the 'tags' attribute to an array
    ];

    public function Collection(): BelongsTo
    {
        return $this->belongsTo(Collection::class);
    }

    public function Varients(): HasMany
    {
        return $this->hasMany(Varient::class);
    }

    public function cartProduct(){
        return $this->belongsToMany(CartProduct::class);
    }

    public function getCheapestVarient(){
        $cheapestVarient = $this->Varients->sortBy('price')->first();
        return $cheapestVarient ? $cheapestVarient->price : 10;
    }

}
