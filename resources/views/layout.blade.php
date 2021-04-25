<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">

        <title>Equalitie</title>
    </head>
    <body class="antialiased">
      <header class="bg-white shadow">
          <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
              <h1 class="text-3xl font-bold text-gray-900 underline">
                  <a href="{{ route('dashboard') }}">Equalitie documents dashboard</a>
              </h1>
          </div>
      </header>
      <main>
          <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
              @yield('body')
          </div>
      </main>
      <script src="{{ mix('js/app.js') }}" ></script>
    </body>
</html>
