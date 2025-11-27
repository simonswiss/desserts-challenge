@props(['product', 'cart'])

@php
$quantity = $cart?->quantityOf($product) ?? 0;
@endphp

<div>
  <img class="object-cover aspect-square rounded-lg" src="{{ Vite::asset('resources/images/' . $product->image_path) }}"
    alt="{{ $product->name }}">
  <div class="flex justify-center h-10 -mt-5">
    @if ($quantity > 0)
    <div class="flex items-center justify-between bg-amber-800 rounded-full px-4 py-2 gap-8 border border-zinc-600">
      {{-- Decrement Button --}}
      <form action="{{ route('cart.reduce', $product) }}" method="POST">
        @csrf @method('PATCH')
        <button type="submit" class="text-white font-bold p-1">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
          </svg>
        </button>
      </form>
      <span class="font-bold text-white">{{ $quantity }}</span>
      {{-- Increment Button (Re-uses Store) --}}
      <form action="{{ route('cart.store', $product) }}" method="POST">
        @csrf
        <button type="submit" class="text-white font-bold p-1">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
          </svg>
        </button>
      </form>
    </div>
    @else
    <form action="{{  route('cart.store', $product) }}" method="POST">
      @csrf
      <button
        class="h-full rounded-full px-8 bg-white border border-zinc-600 text-sm font-semibold hover:bg-amber-200">Add
        to Cart</button>
    </form>
    @endif
  </div>
  <p class="text-zinc-500 mt-2">{{ $product->category }}</p>
  <h2 class="font-bold">{{ $product->name }}</h2>
  <p class="text-amber-800 font-semibold">{{ $product->formattedPrice() }}</p>
</div>