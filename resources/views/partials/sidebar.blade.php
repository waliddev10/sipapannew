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
'route' => 'perusahaan.index'
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
'route' => 'tanggal-libur.index'
],
## --- submenu 2.5 --- #
]
],
# --- menu 2 --- #
# --- menu 3 --- #
(object) [
'title' => 'Penatausahaan',
'icon' => 'fas fa-fw fa-file-alt',
'route' => null,
'submenu' => [
## --- submenu 3.2 --- #
(object) [
'title' => 'Penatausahaan',
'route' => null
],
## --- submenu 3.1 --- #
## --- submenu 3.2 --- #
(object) [
'title' => 'Pelaporan',
'route' => 'pelaporan.index'
],
## --- submenu 3.2 --- #
## --- submenu 3.2 --- #
(object) [
'title' => 'Penetapan',
'route' => 'penetapan.index'
],
## --- submenu 3.2 --- #
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
'route' => 'tarif-pajak.index'
],
## --- submenu 3.2 --- #
## --- submenu 3.2 --- #
(object) [
'title' => 'Nilai Perolehan Air',
'route' => 'npa.index'
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
'route' => 'sanksi-administrasi.index'
],
## --- submenu 3.2 --- #
## --- submenu 3.2 --- #
(object) [
'title' => 'Sanksi Bunga',
'route' => 'sanksi-bunga.index'
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

<ul class="navbar-nav bg-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <img src="{{ asset('assets/img/logo-sipapan.png') }}" height="84">
        </div>
        <div class="sidebar-brand-text mr-3">{{ config('app.name') }}</div>
    </a>

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
            <div class="bg-white py-2 collapse-inner">
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