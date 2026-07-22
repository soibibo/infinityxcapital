<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login — InfinityX Capital</title>
  <link rel="shortcut icon" href="{{ asset('img/favicon-1.ico') }}">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="bg-gray-100 font-sans antialiased">
  <div class="min-h-screen flex items-center justify-center px-6">
    <div class="w-full max-w-sm">
      <div class="text-center mb-8">
        <a href="/" class="text-2xl font-black tracking-tight">
          <span class="text-red-600">infinityx</span><span class="text-gray-800">capital</span>
        </a>
        <p class="mt-2 text-sm text-gray-600">Sign in to the admin panel</p>
      </div>

      <div class="bg-white rounded-2xl shadow-xl p-8">
        <form method="POST" action="{{ route('admin.login') }}">
          @csrf

          <div class="space-y-5">
            <div>
              <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
              <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="email"
                class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors @error('email') border-red-500 @enderror"
                placeholder="admin@infinityxcapital.com"
              >
              @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div x-data="{ show: false }">
              <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
              <div class="relative">
                <input
                  id="password"
                  :type="show ? 'text' : 'password'"
                  name="password"
                  required
                  autocomplete="new-password"
                  class="w-full rounded-xl border border-gray-300 px-4 py-2.5 pr-10 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors @error('password') border-red-500 @enderror"
                  placeholder="••••••••"
                >
                <span @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer text-gray-400 hover:text-gray-600">
                  <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/>
                    <path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/>
                    <path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/>
                    <line x1="2" x2="22" y1="2" y2="22"/>
                  </svg>
                  <svg x-show="show" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                    <circle cx="12" cy="12" r="3"/>
                  </svg>
                </span>
              </div>
              @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div class="flex items-center justify-between">
              <label class="flex items-center gap-2">
                <input type="checkbox" name="remember" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                <span class="text-sm text-gray-600">Remember me</span>
              </label>
            </div>

            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl px-4 py-2.5 text-sm transition-colors">
              Sign in
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

</body>
</html>
