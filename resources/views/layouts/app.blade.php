<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard E-Vote</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans">
    <div x-data="{ mobileMenuOpen: false, profileMenuOpen: false }">
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="flex-shrink-0 flex items-center">
                            <span class="font-bold text-xl text-indigo-600">E-Vote</span>
                        </div>
                        <!-- Navigasi Desktop -->
                        <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                            <a href="{{ route('admin.events.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium
                                      {{ request()->routeIs('admin.events.*') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}">
                                Manajemen Kegiatan
                            </a>
                            <a href="{{ route('admin.voters.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium
                                      {{ request()->routeIs('admin.voters.*') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}">
                                Manajemen Pemilih
                            </a>
                            <a href="{{ route('admin.results.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium
                                      {{ request()->routeIs('admin.results.*') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}">
                                Lihat Hasil Voting
                            </a>
                        </div>
                    </div>

                    <!-- Menu Kanan (Profil & Hamburger) -->
                    <div class="flex items-center">
                        <!-- Dropdown Profil Kanan -->
                        <div @click.away="profileMenuOpen = false" class="relative">
                            <!-- Tombol Trigger Dropdown -->
                            <button @click="profileMenuOpen = !profileMenuOpen" type="button" class="flex items-center text-sm font-medium text-gray-700 hover:text-indigo-600 focus:outline-none transition">
                                <span>Halo, {{ auth()->user()->username }}!</span>
                                <svg class="ml-1 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <!-- Panel Dropdown -->
                            <div x-show="profileMenuOpen" x-transition class="absolute right-0 mt-2 w-48 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-10" style="display: none;">
                                <div class="py-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Hamburger (Mobile) -->
                        <div class="ml-4 -mr-2 flex items-center sm:hidden">
                            <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                                <span class="sr-only">Buka menu utama</span>
                                <!-- Ikon Hamburger -->
                                <svg x-show="!mobileMenuOpen" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                                <!-- Ikon Close (X) -->
                                <svg x-show="mobileMenuOpen" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel Menu Mobile -->
            <div x-show="mobileMenuOpen" class="sm:hidden" style="display: none;">
                <div class="pt-2 pb-3 space-y-1">
                    <a href="{{ route('admin.events.index') }}" class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium
                              {{ request()->routeIs('admin.events.*') ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
                        Manajemen Kegiatan
                    </a>
                    <a href="{{ route('admin.voters.index') }}" class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium
                              {{ request()->routeIs('admin.voters.*') ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
                        Manajemen Pemilih
                    </a>
                    <a href="{{ route('admin.results.index') }}" class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium
                              {{ request()->routeIs('admin.results.*') ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
                        Lihat Hasil Voting
                    </a>
                </div>
            </div>
        </nav>

        <main class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
