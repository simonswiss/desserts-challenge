<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Number;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['session_id'];

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function quantityOf(Product $product): int
    {
        return $this->items->firstWhere('product_id', $product->id)?->quantity ?? 0;
    }

    public function formattedTotal(): string
    {
        $total = $this->items->sum(fn($item) => $item->quantity * $item->product->price_cents);

        return Number::currency($total / 100, 'USD');
    }

    public static function getOrCreate(): self
    {
        return static::firstOrCreate([
            'session_id' => Session::getId(),
        ]);
    }

    public static function current(): ?self
    {
        return static::with('items.product')
            ->where('session_id', Session::getId())
            ->first();
    }

    public function add(Product $product): void
    {
        $this->items()->firstOrCreate(
            ['product_id' => $product->id],
            ['quantity' => 0]
        )->increment('quantity');
    }

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
}
