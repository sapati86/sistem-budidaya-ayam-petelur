<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Sistem Budidaya Ayam Petelur</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">

    <div class="w-64 bg-white shadow-lg">
        <div class="p-4 border-b">
            <h1 class="text-xl font-bold text-blue-600">🐔 Ayam Petelur</h1>
            <p class="text-sm text-gray-500">Sistem Informasi Manajemen</p>
        </div>

        <nav class="p-4">
            <div class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded hover:bg-blue-50">
                    <i class="fas fa-home mr-2"></i> Dashboard
                </a>

                @role('admin')
                    
                    <a href="{{ route('admin.kandang.index') }}" class="block px-4 py-2 rounded hover:bg-blue-50">
                        <i class="fas fa-warehouse mr-2"></i> Kandang
                    </a>

                    <a href="{{ route('admin.ayam.index') }}" class="block px-4 py-2 rounded hover:bg-blue-50">
                        <i class="fas fa-dove mr-2"></i> Ayam
                    </a>

                    <a href="{{ route('admin.produksi.index') }}" class="block px-4 py-2 rounded hover:bg-blue-50">
                        <i class="fas fa-egg mr-2"></i> Produksi
                    </a>

                    <a href="{{ route('admin.pakan.index') }}" class="block px-4 py-2 rounded hover:bg-blue-50">
                        <i class="fas fa-box mr-2"></i> Pakan
                    </a>

                    <a href="{{ route('admin.kesehatan.index') }}" class="block px-4 py-2 rounded hover:bg-blue-50">
                        <i class="fas fa-heartbeat mr-2"></i> Kesehatan
                    </a>

                    <a href="{{ route('admin.konsumsi.index') }}" class="block px-4 py-2 rounded hover:bg-blue-50">
                        <i class="fas fa-utensils mr-2"></i> Konsumsi
                    </a>

                    <a href="{{ route('admin.laporan.index') }}" class="block px-4 py-2 rounded hover:bg-blue-50">
                        <i class="fas fa-file-alt mr-2"></i> Laporan
                    </a>

                    <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 rounded hover:bg-blue-50">
                        <i class="fas fa-users-cog mr-2"></i> Manajemen User
                    </a>
                @endrole

                @role('user')
                    <a href="{{ route('admin.kandang.index') }}" class="block px-4 py-2 rounded hover:bg-blue-50">
                        <i class="fas fa-warehouse mr-2"></i> Kandang
                    </a>

                    <a href="{{ route('admin.ayam.index') }}" class="block px-4 py-2 rounded hover:bg-blue-50">
                        <i class="fas fa-dove mr-2"></i> Ayam
                    </a>

                    <a href="{{ route('admin.produksi.index') }}" class="block px-4 py-2 rounded hover:bg-blue-50">
                        <i class="fas fa-egg mr-2"></i> Produksi
                    </a>

                    <a href="{{ route('admin.kesehatan.index') }}" class="block px-4 py-2 rounded hover:bg-blue-50">
                        <i class="fas fa-heartbeat mr-2"></i> Kesehatan
                    </a>

                    <a href="{{ route('admin.konsumsi.index') }}" class="block px-4 py-2 rounded hover:bg-blue-50">
                        <i class="fas fa-utensils mr-2"></i> Konsumsi
                    </a>
                @endrole
            </div>

            <div class="mt-8 pt-4 border-t">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 rounded hover:bg-red-50 text-red-600">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            </div>
        </nav>
    </div>
        
        <div class="flex-1">

            <header class="bg-white shadow-sm p-4">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-semibold">@yield('header')</h2>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-600">{{ Auth::user()->name }}</span>
                        <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">
                            {{ ucfirst(Auth::user()->role) }}
                        </span>
                    </div>
                </div>
            </header>
            
            
            <main class="p-6">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>