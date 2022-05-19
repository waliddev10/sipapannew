@php
$menu = collect([
# --- menu 1 --- #
(object) [
'title' => 'Beranda',
'icon' => 'fas fa-fw fa-tachometer-alt',
'route' => 'dashboard',
'submenu' => null
],
# --- menu 1 --- #
# --- menu 2 --- #
(object) [
'title' => 'Database',
'icon' => 'fas fa-fw fa-database',
'route' => null,
'submenu' => [
## --- submenu 2.1 --- #
(object) [
'title' => 'Perusahaan',
'route' => null
],
## --- submenu 2.1 --- #
## --- submenu 2.2 --- #
(object) [
'title' => 'Daftar Perusahaan',
'route' => 'database.perusahaan'
],
## --- submenu 2.2 --- #
## --- submenu 2.3 --- #
(object) [
'title' => 'Administrasi',
'route' => null
],
## --- submenu 2.3 --- #
## --- submenu 2.4 --- #
(object) [
'title' => 'Masa Pajak',
'route' => 'masa-pajak.index'
],
## --- submenu 2.4 --- #
## --- submenu 2.5 --- #
(object) [
'title' => 'Tanggal Libur',
'route' => 'database.tanggal-libur'
],
## --- submenu 2.5 --- #
]
],
# --- menu 2 --- #
# --- menu 3 --- #
(object) [
'title' => 'Ketentuan',
'icon' => 'fas fa-fw fa-book',
'route' => null,
'submenu' => [
## --- submenu 3.1 --- #
(object) [
'title' => 'Umum',
'route' => null
],
## --- submenu 3.1 --- #
## --- submenu 3.2 --- #
(object) [
'title' => 'Jenis Usaha',
'route' => 'jenis-usaha.index'
],
## --- submenu 3.2 --- #
## --- submenu 3.2 --- #
(object) [
'title' => 'Tarif Pajak',
'route' => 'database.perusahaan'
],
## --- submenu 3.2 --- #
## --- submenu 3.2 --- #
(object) [
'title' => 'Nilai Perolehan Air',
'route' => 'database.perusahaan'
],
## --- submenu 3.2 --- #
## --- submenu 3.2 --- #
(object) [
'title' => 'Cara Pelaporan',
'route' => 'cara-pelaporan.index'
],
## --- submenu 3.2 --- #
## --- submenu 3.1 --- #
(object) [
'title' => 'Sanksi',
'route' => null
],
## --- submenu 3.1 --- #
## --- submenu 3.2 --- #
(object) [
'title' => 'Sanksi Administrasi',
'route' => 'database.perusahaan'
],
## --- submenu 3.2 --- #
## --- submenu 3.2 --- #
(object) [
'title' => 'Sanksi Bunga',
'route' => 'database.perusahaan'
],
## --- submenu 3.2 --- #
]
],
# --- menu 2 --- #
# --- menu 3 --- #
(object) [
'title' => 'Pelaporan',
'icon' => 'fas fa-fw fa-paper-plane',
'route' => null,
'submenu' => [
## --- submenu 3.2 --- #
// (object) [
// 'title' => 'Aplikasi',
// 'route' => null
// ],
## --- submenu 3.1 --- #
## --- submenu 3.2 --- #
(object) [
'title' => 'Jatuh Tempo',
'route' => 'database.perusahaan'
],
## --- submenu 3.2 --- #
## --- submenu 3.2 --- #
(object) [
'title' => 'Pelaporan',
'route' => 'database.perusahaan'
],
## --- submenu 3.2 --- #
]
],
# --- menu 2 --- #
# --- menu 3 --- #
(object) [
'title' => 'Penetapan',
'icon' => 'fas fa-fw fa-gavel',
'route' => null,
'submenu' => [
## --- submenu 3.2 --- #
// (object) [
// 'title' => 'Aplikasi',
// 'route' => null
// ],
## --- submenu 3.1 --- #
## --- submenu 3.2 --- #
(object) [
'title' => 'Surat Ketetapan',
'route' => 'database.perusahaan'
],
## --- submenu 3.2 --- #
## --- submenu 3.2 --- #
(object) [
'title' => 'Pembayaran',
'route' => 'database.perusahaan'
],
## --- submenu 3.2 --- #
]
],
# --- menu 2 --- #
# --- menu 3 --- #
(object) [
'title' => 'Setting',
'icon' => 'fas fa-fw fa-wrench',
'route' => null,
'submenu' => [
## --- submenu 3.2 --- #
(object) [
'title' => 'Aplikasi',
'route' => null
],
## --- submenu 3.1 --- #
## --- submenu 3.2 --- #
(object) [
'title' => 'Setting Penandatangan',
'route' => 'penandatangan.index'
],
## --- submenu 3.2 --- #
## --- submenu 3.2 --- #
(object) [
'title' => 'Setting Kota',
'route' => 'kota-penandatangan.index'
],
## --- submenu 3.2 --- #
]
],
# --- menu 2 --- #
]);
@endphp

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ config('app.name') }}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    @foreach ($menu as $m)
    @if(!empty($m->submenu))
    <li
        class="nav-item @foreach($m->submenu as $xsm) @if(collect($xsm)->contains(Route::currentRouteName())) active @endif @endforeach">
        <a href="javascript:void(0)" class="nav-link collapsed" data-toggle="collapse"
            data-target="#{{ Str::slug($m->title) }}" aria-expanded="true" aria-controls="{{ Str::slug($m->title) }}">
            <i class="{{ $m->icon }}"></i>
            <span>{{ $m->title }}</span>
        </a>
        <div id="{{ Str::slug($m->title) }}"
            class="collapse @foreach($m->submenu as $xsm) @if(collect($xsm)->contains(Route::currentRouteName())) show @endif @endforeach"
            aria-labelledby="{{ Str::slug($m->title) }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @foreach ($m->submenu as $sm)
                @if(!empty($sm->route))
                <a class="collapse-item @if(Route::is($sm->route)) active @endif" href="{{ URL::route($sm->route) }}">{{
                    $sm->title }}</a>
                @else
                <h6 class="collapse-header">{{ $sm->title }}</h6>
                @endif
                @endforeach
            </div>
        </div>
    </li>
    @else
    <li class="nav-item @if(Route::is($m->route)) active @endif">
        <a class="nav-link" href="{{ URL::route($m->route) }}">
            <i class="{{ $m->icon }}"></i>
            <span>{{ $m->title }}</span>
        </a>
    </li>
    @endif
    @endforeach

    {{--
    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Beranda</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Administrasi
    </div>

    <li class="nav-item">
        <a class="nav-link collapsed" style="cursor: pointer;" data-toggle="collapse" data-target="#basis-data"
            aria-expanded="true" aria-controls="basis-data">
            <i class="fas fa-fw fa-database"></i>
            <span>Basis Data</span>
        </a>
        <div id="basis-data" class="collapse" aria-labelledby="basis-data" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Perusahaan</h6>
                <a class="collapse-item" href="{{ route('database.perusahaan') }}">Daftar Perusahaan</a>
                <h6 class="collapse-header">Administrasi</h6>
                <a class="collapse-item" href="utilities-color.html">Masa Pajak</a>
                <a class="collapse-item" href="utilities-color.html">Tanggal/Hari Libur</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" style="cursor: pointer;" data-toggle="collapse" data-target="#pelaporan"
            aria-expanded="true" aria-controls="pelaporan">
            <i class="fas fa-fw fa-clock"></i>
            <span>Pelaporan</span>
        </a>
        <div id="pelaporan" class="collapse" aria-labelledby="pelaporan" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="buttons.html">Jatuh Tempo</a>
                <a class="collapse-item" href="utilities-color.html">Pelaporan</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" style="cursor: pointer;" data-toggle="collapse" data-target="#penagihan"
            aria-expanded="true" aria-controls="penagihan">
            <i class="fas fa-fw fa-gavel"></i>
            <span>Penagihan</span>
        </a>
        <div id="penagihan" class="collapse" aria-labelledby="penagihan" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="buttons.html">Penetapan</a>
                <a class="collapse-item" href="utilities-color.html">Pembayaran</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" style="cursor: pointer;" data-toggle="collapse" data-target="#pengaturan"
            aria-expanded="true" aria-controls="pengaturan">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Pengaturan</span>
        </a>
        <div id="pengaturan" class="collapse" aria-labelledby="pengaturan" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Administrasi</h6>
                <a class="collapse-item" href="utilities-color.html">Jenis Usaha</a>
                <a class="collapse-item" href="utilities-color.html">Tarif Pajak</a>
                <a class="collapse-item" href="utilities-color.html">Nilai Perolehan Air</a>
                <h6 class="collapse-header">Sanksi</h6>
                <a class="collapse-item" href="utilities-color.html">Sanksi Administrasi</a>
                <a class="collapse-item" href="utilities-color.html">Sanksi Bunga</a>
                <h6 class="collapse-header">Aplikasi</h6>
                <a class="collapse-item" href="utilities-color.html">Cara Pelaporan</a>
                <a class="collapse-item" href="utilities-color.html">Penandatangan</a>
                <a class="collapse-item" href="utilities-border.html">Setting Kota</a>
            </div>
        </div>
    </li> --}}

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Message -->
    <div class="sidebar-card d-none d-lg-flex">
        <p class="text-center mb-2"><strong>{{ config('app.name') }} {{ config('app.version')
                }}</strong>
            <br />
            {{ config('app.description') }}
        </p>
        <a class="btn btn-success btn-sm" href="https://wa.me/6285172277277"><i class="fab fa-whatsapp"></i>
            Kontak Kami</a>
    </div>

</ul>