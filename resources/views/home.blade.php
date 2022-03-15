<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/svg+xml" href="favicon.svg">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cnvrtr</title>

  {{--Only For Development Use --}}
  <script type="module" src="http://localhost:3000/@vite/client"></script>
  <script type="module" src="http://localhost:3000/resources/ts/main.ts"></script>

  {{--For Production--}}
  {{--TODO: figure out how to use and read manifest file in dist folder after the build--}}
  <!--<link rel="stylesheet" href="/assets/manifest['main.js'].css" />
  <script type="module" src="/assets/manifest['main.js'].file"></script>-->
</head>
<body>
  {{--TODO: Partials --}}
  <div id="app">jfh</div>
  <div class="bg-black flex justify-center items-center text-blue w-full h-20">
    {{ ucwords($name[0] . " " . $name[1]) }}
  </div>
</body>
</html>