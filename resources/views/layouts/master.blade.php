<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Judul Default')</title>
    @include('components.topscript')
</head>
<body>
    @include('layouts.components.navbar')

    <div class="container-fluid">
        @yield('content')
    </div>

    @include('layouts.components.footer')

    @include('components.bottomscript')
</body>
</html>
