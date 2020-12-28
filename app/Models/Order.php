<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\This;

class Order extends Model
{
    use HasFactory;

    public function products() {
        return $this->belongsToMany(Product::class)->withPivot('count')->withTimestamps();
    }
}
