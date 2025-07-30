<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login E-Vote</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full max-w-md p-8 space-y-8 bg-white rounded-xl shadow-lg">

            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-900">
                    Login Sistem E-Vote
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Silakan masuk menggunakan akun Anda.
                </p>
            </div>

            <form class="mt-8 space-y-6" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label for="username" class="text-sm font-medium text-gray-700">Username</label>
                        <input id="username" name="username" type="text" required autofocus value="{{ old('username') }}" class="block w-full px-3 py-2 mt-1 placeholder-gray-400 bg-gray-50 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('username') border-red-500 @enderror">
                        @error('username')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="text-sm font-medium text-gray-700">Password</label>
                        <input id="password" name="password" type="password" required class="block w-full px-3 py-2 mt-1 placeholder-gray-400 bg-gray-50 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>

                <div>
                    <button type="submit" class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Masuk
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
