<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Number;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'session_id'];

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function total(): string
    {
        $total = $this->items->sum(fn($item) => $item->quantity * $item->product->price_cents);

        return Number::currency($total / 100, 'USD');
    }

    // ------------------------------
    // For backend use only
    // ------------------------------
    public static function getOrNew(): self
    {
        // Might not implement that, scope creep...
        if (Auth::check()) {
            return static::firstOrCreate([
                'user_id' => Auth::id(),
            ]);
        }

        // Otherwise, find by Session
        return static::firstOrCreate([
            'session_id' => Session::getId(),
        ]);
    }

    // ------------------------------
    // For frontend use.This allows us to delay creating the cart until the user adds an item.
    // Probably a much better idea than creating one on page load, 
    // which would clutter the db with so much junk.
    // ------------------------------
    public static function getOrNull(): ?self
    {

        $query = static::with('items.product');

        if (Auth::check()) {
            return $query->where('user_id', Auth::id())->first();
        }

        return $query->where('session_id', Session::getId())->first();
    }

    // ------------------------------
    // Increase quantity by 1 (or create new line item!)
    // ------------------------------
    public function add(Product $product, int $quantity = 1): void
    {
        $item = $this->items()->where('product_id', $product->id)->first();

        if ($item) {
            $item->increment('quantity', $quantity);
        } else {
            $this->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
        }
    }

    // ------------------------------
    // Reduce quantity by 1
    // ------------------------------
    public function reduce(Product $product): void
    {
        $item = $this->items()->where('product_id', $product->id)->first();

        if (! $item) return;

        if ($item->quantity <= 1) {
            $item->delete();
        } else {
            $item->decrement('quantity');
        }
    }

    // ------------------------------
    // Remove line item
    // ------------------------------
    public function remove(Product $product): void
    {
        $this->items()->where('product_id', $product->id)->delete();
    }
}
