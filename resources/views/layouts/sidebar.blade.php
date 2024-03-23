<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-info"
    id="sidenav-main">
    <div class="collapse navbar-collapse w-auto max-height-vh-100" id="sidenav-collapse-main">
        <ul class="navbar-nav mt-3">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }} text-white"
                    href="{{ route('dashboard') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            @if (auth()->user() && auth()->user()->hasRole('ADMIN'))
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('user') ? 'active' : '' }} text-white" href="{{ route('user') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">person</i>
                        </div>
                        <span class="nav-link-text ms-1">User</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('criteria') || Request::is('subciteria*') ? 'active' : '' }} text-white"
                        href="{{ route('criteria') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">tune</i>
                        </div>
                        <span class="nav-link-text ms-1">Kriteria</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('division') ? 'active' : '' }} text-white"
                        href="{{ route('division') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">badge</i>
                        </div>
                        <span class="nav-link-text ms-1">Divisi</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('employee') ? 'active' : '' }} text-white"
                        href="{{ route('employee') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">people</i>
                        </div>
                        <span class="nav-link-text ms-1">Pegawai</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white" data-bs-toggle="collapse" href="#collapsePerhitungan" role="button"
                        aria-expanded="false" aria-controls="collapsePerhitungan">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons">grid_on</i>
                        </div>
                        <span class="nav-link-text ms-1">Penilaian</span>
                    </a>
                    <div class="collapse" id="collapsePerhitungan">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('assessment') ? 'active' : '' }} text-white"
                                    style="padding-left: 35px;" href="{{ route('assessment') }}">
                                    <div
                                        class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                        <i class="material-icons">assessment</i>
                                    </div>
                                    <span class="nav-link-text ms-1">Input Nilai</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('assessment/matrix') ? 'active' : '' }} text-white"
                                    style="padding-left: 35px;" href="{{ route('assessment.matrix') }}">
                                    <div
                                        class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                        <i class="material-icons">calculate</i>
                                    </div>
                                    <span class="nav-link-text ms-1">Hasil Penilaian</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('assessment') ? 'active' : '' }} text-white"
                        href="{{ route('assessment') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">assessment</i>
                        </div>
                        <span class="nav-link-text ms-1">Input Nilai</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</aside>
