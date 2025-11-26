<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Frontend Mentor | Product list with cart</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Text:ital,wght@0,300..700;1,300..700&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-red-hat-text bg-amber-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 py-20">
        <div class="grid md:grid-cols-[1fr_400px] gap-8">
            <main>
                <h1 class="text-4xl font-bold text-amber-950">Desserts</h1>
                <div class="mt-8 grid lg:grid-cols-2 xl:grid-cols-3 gap-x-6 gap-y-8">
                    @foreach ($products as $product)
                    <x-product :product="$product" :cart="$cart" />
                    @endforeach
                </div>
            </main>
            <aside>
                <x-cart :cart="$cart" />
            </aside>
        </div>
    </div>
</body>

</html>