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

  @if($debug)
    {{--Only For Development Use --}}
    <script type="module" src="http://localhost:3000/@vite/client"></script>
    <script type="module" src="http://localhost:3000/resources/ts/main.ts"></script>
  @else
    {{--For Production--}}
    @foreach($manifest['css'] as $css)
      <link rel="stylesheet" href="{{ $css }}" />
    @endforeach

    <script type="module" src="{{ $manifest['file'] }}"></script>
  @endif
</head>
<body>
  <div id="app">
    @include('partials.header-overlay')
    @include('partials.header')
    @yield('content')
    @include('partials.footer')
    @include('partials.errors')
  </div>
</body>
</html>