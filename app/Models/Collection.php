<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Collection extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function Products(): hasMany
    {
        return $this->hasMany(Product::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
