<body class="g-sidenav-show  bg-gray-200">

    @include('layouts.sidebar')

    @include('layouts.navbar')

    @isset($content)
    {{$content}}
    @endisset

    {{-- @yield('content') --}}

    @include('layouts.footer')