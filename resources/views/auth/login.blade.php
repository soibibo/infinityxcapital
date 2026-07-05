<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login — InfinityX Capital</title>
  <link rel="shortcut icon" href="{{ asset('img/favicon-1.ico') }}">
  @vite(['resources/css/app.css'])
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
        <form method="POST" action="{{ route('login') }}">
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

            <div>
              <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
              <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition-colors @error('password') border-red-500 @enderror"
                placeholder="••••••••"
              >
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
