<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Dashboard') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap');
        body { font-family: 'Tajawal', sans-serif; }
    </style>
</head>
<body class="antialiased bg-gray-900"> <div class="fixed inset-0 z-0 bg-cover bg-center opacity-50"
                                            style="background-image: url('https://www.freevector.com/uploads/vector/preview/6761/FreeVector-Online-Food-Order.jpg');">
</div>

<div class="fixed inset-0 z-10 bg-black/60 backdrop-blur-sm"></div>

<div class="relative z-20 min-h-screen flex items-center justify-center p-4">
    <div class="fi-main-ctn w-full max-w-4xl flex flex-col gap-y-8 text-center">

        <header class="text-white">
            <h1 class="text-3xl font-bold shadow-sm">اختر المتجر الذي تريد إدارته</h1>
        </header>

        @if ($stores->isEmpty())
            <div class="bg-white/10 backdrop-blur-md p-8 rounded-2xl border border-white/20 text-white">
                <p class="text-xl">ليس لديك متاجر حالياً. يرجى إنشاء واحد للبدء.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($stores as $store)
                    <a href="{{ route('seller.select-store', $store) }}"
                       class="group block bg-white/90 backdrop-blur-lg p-6 rounded-2xl shadow-2xl hover:bg-white transition-all duration-300 transform hover:-translate-y-2">
                        <div class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors">{{ $store->name }}</div>
                        <div class="text-sm text-gray-500 mb-4">{{ $store->slug }}</div>

                        @if ($store->isOpenNow())
                            <div class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-600 text-sm font-medium">
                                <span class="w-2 h-2 bg-green-500 rounded-full ml-2 animate-pulse"></span>
                                مفتوح الآن
                            </div>
                        @else
                            <div class="inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-600 text-sm font-medium">
                                <span class="w-2 h-2 bg-red-500 rounded-full ml-2"></span>
                                مغلق
                            </div>
                        @endif
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>

</body>
</html>
