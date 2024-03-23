@include('layouts.header')

<body class="bg-gray-200">
    @include('sweetalert::alert')
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                <!-- Navbar -->
                <!-- <x-login-nav /> -->
                <!-- End Navbar -->
            </div>
        </div>
    </div>

    <main class="main-content  mt-0">
        <div class="page-header align-items-start min-vh-100">
            <span class="mask bg-gradient-white opacity-6"></span>
            <div class="container my-auto">
                <div class="row">
                    <div class="col-lg-4 col-md-8 col-12 mx-auto">
                        <div class="card z-index-0 fadeIn3 fadeInBottom">
                            <div class="card-body">

                                <form method="POST" action="{{ route('signin') }}">

                                    @csrf

                                    <div class="mb-3">
                                        <label for="exampleInputEmail1"
                                            class="form-label @error('email') text-danger @enderror">Email
                                            address</label>
                                        <input type="email"
                                            class="form-control border ps-2 @error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email') }}">
                                        @error('email')
                                            <span class="text-danger text-xs my-2">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="exampleInputPassword1"
                                            class="form-label @error('password') text-danger @enderror">Password</label>
                                        <input type="password"
                                            class="form-control border ps-2 @error('password') is-invalid @enderror"
                                            name="password">
                                        @error('password')
                                            <span class="text-danger text-xs my-2">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    @error('auth_login')
                                        <div class="text-center">
                                            <span class="text-danger my-2">{{ $message }}</span>
                                        </div>
                                    @enderror
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Sign
                                            in</button>
                                    </div>

                                    <p class="mt-4 text-sm text-end">
                                        Go Back to
                                        <a href="{{ asset('/') }}"
                                            class="text-primary text-gradient font-weight-bold"> 🏡 Home</a>
                                    </p>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="footer position-absolute bottom-2 py-2 w-100">
                <div class="container">
                    <div class="row align-items-center justify-content-lg-between">
                        <div class="col-12 col-md-12 my-auto">
                            <div class="copyright text-center text-sm text-black text-lg-center">
                                © {{ date('Y') }} The Employee Decision Support System
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </main>



    <!--   Core JS Files   -->
    <script src="{{ asset('/') }}js/core/popper.min.js"></script>
    <script src="{{ asset('/') }}js/core/bootstrap.min.js"></script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>
