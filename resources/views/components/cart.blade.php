@props(['cart'])

@php
$itemCount = $cart?->items->count() ?? 0;
@endphp

<div class="bg-white p-6 rounded-lg">
 <h2 class="text-2xl font-extrabold text-amber-950">Your Cart ({{ $itemCount }})</h2>

 {{-- Line items --}}
 @if ($itemCount > 0)
 <ul class="mt-6">
  @foreach ($cart->items as $item)
  <li class="py-4 flex items-center justify-between gap-4 border-b border-zinc-200">
   <div>
    <h3 class="font-semibold">{{ $item->product->name }}</h3>
    <div class="mt-1 flex gap-3 items-center">

     <p class="text-amber-900 font-semibold">{{ $item->quantity }}x</p>
     <p class="text-zinc-500">@ {{ $item->product->price() }}</p>
     <p class="font-semibold text-zinc-600">{{ $item->total() }}</p>
    </div>
   </div>
   <form action="{{ route('cart.destroy') }}" method="POST">
    @csrf
    @method('DELETE')
    <input type="hidden" name="product_id" value="{{ $item->product->id }}">
    <button type="submit" class="text-red-500 hover:text-red-700 font-bold p-1">
     &times;
    </button>
   </form>
  </li>
  @endforeach
 </ul>

 {{-- Total --}}
 <div class="mt-6 flex justify-between items-center">
  <p class="text-sm text-zinc-500">Order Total</p>
  <p class="text-3xl font-black">{{ $cart->total() }}</p>
 </div>

 <p class="p-4 rounded-md bg-zinc-200 mt-6 text-center">This is a carbon-neutral delivery.</p>

 <button popovertarget="confirm-order" class="bg-amber-800 text-white py-4 rounded-full w-full mt-6">Confirm
  Order</button>

 <div popover id="confirm-order"
  class="bg-transparent m-auto [&::backdrop]:bg-zinc-900/50 [&::backdrop]:backdrop-blur-sm">
  <div class="bg-white p-8 rounded-lg w-120 max-w-full">
   <h2 class="text-3xl font-black">Order Confirmed</h2>
   <p class="mt-1 text-zinc-600">We hope you enjoy your food!</p>

   <ul class="mt-6">
    @foreach ($cart->items as $item)
    <li class="py-4 flex items-center justify-between gap-4 border-b border-zinc-200">
     <div>
      <h3 class="font-semibold">{{ $item->product->name }}</h3>
      <div class="mt-1 flex gap-3 items-center">

       <p class="text-amber-900 font-semibold">{{ $item->quantity }}x</p>
       <p class="text-zinc-500">@ {{ $item->product->price() }}</p>
      </div>
     </div>
     <p class="font-semibold text-zinc-600">{{ $item->total() }}</p>
    </li>
    @endforeach
   </ul>

   {{-- Total --}}
   <div class="mt-6 flex justify-between items-center">
    <p class="text-sm text-zinc-500">Order Total</p>
    <p class="text-xl font-black">{{ $cart->total() }}</p>
   </div>

   <form action="{{ route('cart.clear') }}" method="POST">
    @csrf
    <button type="submit" class="bg-amber-800 text-white py-4 rounded-full w-full mt-8">Start New
     Order</button>
  </div>
 </div>

 @else
 <p class="mt-4 text-sm">Your cart is empty</p>
 @endif
</div>