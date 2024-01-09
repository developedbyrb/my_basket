<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id', 'brand', 'price', 'weight', 'return_policy', 'length',
        'width', 'breadth', 'ships_from', 'ship_by', 'import_fees', 'state'
    ];
}
