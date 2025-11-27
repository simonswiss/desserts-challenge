<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Number;

class Product extends Model
{
    public function formattedPrice(): string
    {
        return Number::currency($this->price_cents / 100, 'USD');
    }
}
