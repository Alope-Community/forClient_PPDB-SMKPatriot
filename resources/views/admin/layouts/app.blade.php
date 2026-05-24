<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin PPDB')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { 'inter': ['Inter', 'sans-serif'] } } }
        }
    </script>
</head>
<body class="bg-gray-50 font-inter">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-linear-to-r from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Admin PPDB</h1>
                        <p class="text-xs text-gray-500">Penerimaan Peserta Didik Baru</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm font-medium text-gray-700 hidden md:block">
                        {{ session('admin_username', 'Admin') }}
                    </span>
                    <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-all duration-200 flex items-center space-x-2">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="w-64 bg-white shadow-lg border-r border-gray-200 fixed left-0 top-0 bottom-0">
        <nav class="mt-8 px-4">
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center px-4 py-3 text-gray-700 rounded-xl mb-2 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 border-2 border-blue-200 font-semibold' : 'hover:bg-gray-100' }}">
                <i class="fas fa-tachometer-alt w-5 mr-3 text-blue-500"></i>
                Dashboard
            </a>
            <a href="{{ route('admin.pendaftar') }}" 
               class="flex items-center px-4 py-3 text-gray-700 rounded-xl mb-2 {{ request()->routeIs('admin.pendaftar*') ? 'bg-green-50 border-2 border-green-200 font-semibold' : 'hover:bg-gray-100' }}">
                <i class="fas fa-users w-5 mr-3 text-green-500"></i>
                Pendaftar
            </a>
        </nav>
    </div>
    <div class="flex">
        <div class="w-64"> </div>
        <!-- Main Content -->
        <div class="flex-1 p-8">
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-2xl flash-message">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                        <span class="font-medium text-green-800">{{ session('success') }}</span>
                    </div>
                </div>
            @endif
            @yield('content')
        </div>
    </div>

    <script>
        // Auto hide success message
        setTimeout(() => {
            const alerts = document.querySelectorAll('.flash-message');
            alerts.forEach(alert => alert.remove());
        }, 1000);
    </script>
</body>
</html>