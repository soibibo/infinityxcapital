<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Tesla Motors')</title>
  <meta name="description" content="@yield('meta_description', 'Tesla motors')">
  <meta name="author" content="Lovable">
  <meta property="og:type" content="website">
  <meta property="og:image" content="{{ asset('img/tesla-logo.png') }}">
  <meta name="twitter:card" content="summary_large_image">
  <meta property="og:title" content="Tesla Motors">
  <meta name="twitter:title" content="Tesla Motors">
  <meta property="og:description" content="Tesla motors">
  <meta name="twitter:description" content="Tesla motors">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @stack('styles')
  <link rel="shortcut icon" href="{{ asset('img/favicon-1.ico') }}">
  @livewireStyles
</head>
<body>
  <div id="root">
    {{ $slot }}
  </div>

  <script>
    function switchTab(sec, tab) {
      var video = document.getElementById(sec + '-video');
      var comments = document.getElementById(sec + '-comments');
      var tabVideo = document.getElementById(sec + '-tab-video');
      var tabComments = document.getElementById(sec + '-tab-comments');
      if (tab === 'video') {
        video.style.display = 'block';
        comments.style.display = 'none';
        tabVideo.className = 'flex-1 py-2 text-sm font-bold transition-colors bg-red-600 text-white';
        tabComments.className = 'flex-1 py-2 text-sm font-bold transition-colors bg-gray-800 text-gray-400';
      } else {
        video.style.display = 'none';
        comments.style.display = 'block';
        tabVideo.className = 'flex-1 py-2 text-sm font-bold transition-colors bg-gray-800 text-gray-400';
        tabComments.className = 'flex-1 py-2 text-sm font-bold transition-colors bg-red-600 text-white';
      }
    }
  </script>
  <script src="{{ asset('js/popup.js') }}"></script>
  <script src="{{ asset('js/testimonials.js') }}"></script>
  @stack('scripts')
  @livewireScripts
</body>
</html>