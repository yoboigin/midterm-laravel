<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-900">

    @include('layouts.sidebar')

    <div class="pl-80">
        <main class="max-w-10xl mx-auto pt-10 px-4">
            @if (session('success'))
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    class="mb-4 flex items-center justify-between rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800"
                    role="alert"
                >
                    <span>{{ session('success') }}</span>
                    <button
                        type="button"
                        @click="show = false"
                        class="ml-4 rounded-lg p-1 text-emerald-600 hover:bg-emerald-100 transition"
                        aria-label="Dismiss"
                    >&times;</button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</body>
</html>
