<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeOptionSku extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku_id',
        'attribute_option_id',
    ];

    public $timestamps = false;
}
