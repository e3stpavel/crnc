<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/svg+xml" href="favicon.svg">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title')</title>

  <link rel="preload" href="./assets/fonts/Guaruja-Grotesk-Regular.woff2" as="font" type="font/woff2" crossorigin>
  <link rel="preload" href="./assets/fonts/Neue-Machina-Regular.woff2" as="font" type="font/woff2" crossorigin>
  <link rel="preload" href="./assets/fonts/Hauora-Regular.woff2" as="font" type="font/woff2" crossorigin>

  {{--Only For Development Use --}}
  <script type="module" src="http://localhost:3000/@vite/client"></script>
  <script type="module" src="http://localhost:3000/resources/ts/main.ts"></script>

  {{--For Production--}}
  {{--TODO: figure out how to use and read manifest file in dist folder after the build--}}
  <!--<link rel="stylesheet" href="/assets/manifest['main.js'].css" />
  <script type="module" src="/assets/manifest['main.js'].file"></script>-->
</head>
<body>
  <div id="app">
    @include('partials.header')
    @yield('content')
    @include('partials.footer')
  </div>
</body>
</html>