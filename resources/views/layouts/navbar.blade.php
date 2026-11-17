<nav class="navbar navbar-expand-xl navbar-light shadow-sm py-2" style="background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%); border-bottom: 1px solid #7dd3fc;">
    <div class="container-fluid px-lg-4">

        {{-- Logo / Nama Aplikasi --}}
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2 me-4" href="{{ url('/') }}" style="color: #0369a1; font-size: 18px;">
            <span class="rounded-circle d-inline-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 34px; height: 34px; font-size: 15px; background-color: #ffffff; color: #0284c7;">P</span>
            <span class="text-nowrap">Peminjaman Alat</span>
        </a>

        {{-- Tombol Mobile --}}
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#menuUtama">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuUtama">

            <ul class="navbar-nav me-auto align-items-lg-center gap-lg-1">

                {{-- KATEGORI --}}
                @can('kategori.kelola')
                    <li class="nav-item">
                        <a class="nav-link text-nowrap px-3 {{ request()->routeIs('kategori.*') ? 'fw-bold' : 'fw-semibold' }}" 
                           style="color: {{ request()->routeIs('kategori.*') ? '#0c4a6e' : '#0369a1' }}; font-size: 15px;" 
                           href="{{ route('kategori.index') }}">
                            Kategori
                        </a>
                    </li>
                @endcan

                {{-- ALAT --}}
                @can('alat.kelola')
                    <li class="nav-item">
                        <a class="nav-link text-nowrap px-3 {{ request()->routeIs('alat.*') ? 'fw-bold' : 'fw-semibold' }}" 
                           style="color: {{ request()->routeIs('alat.*') ? '#0c4a6e' : '#0369a1' }}; font-size: 15px;" 
                           href="{{ route('alat.index') }}">
                            Alat
                        </a>
                    </li>
                @endcan

                {{-- PENGGUNA --}}
                @can('user.kelola')
                    <li class="nav-item">
                        <a class="nav-link text-nowrap px-3 {{ request()->routeIs('pengguna.*') ? 'fw-bold' : 'fw-semibold' }}" 
                           style="color: {{ request()->routeIs('pengguna.*') ? '#0c4a6e' : '#0369a1' }}; font-size: 15px;" 
                           href="{{ route('pengguna.index') }}">
                            Pengguna
                        </a>
                    </li>
                @endcan

                {{-- LOG AKTIVITAS --}}
                @can('log.lihat')
                    <li class="nav-item">
                        <a class="nav-link text-nowrap px-3 {{ request()->routeIs('log.*') ? 'fw-bold' : 'fw-semibold' }}" 
                           style="color: {{ request()->routeIs('log.*') ? '#0c4a6e' : '#0369a1' }}; font-size: 15px;" 
                           href="{{ route('log.index') }}">
                            Log Aktivitas
                        </a>
                    </li>
                @endcan

                {{-- DATA PEMINJAMAN --}}
                @can('peminjaman.kelola')
                    <li class="nav-item">
                        <a class="nav-link text-nowrap px-3 {{ request()->routeIs('koreksi.peminjaman.*') ? 'fw-bold' : 'fw-semibold' }}" 
                           style="color: {{ request()->routeIs('koreksi.peminjaman.*') ? '#0c4a6e' : '#0369a1' }}; font-size: 15px;" 
                           href="{{ route('koreksi.peminjaman.daftar') }}">
                            Data Peminjaman
                        </a>
                    </li>
                @endcan

                {{-- DATA PENGEMBALIAN --}}
                @can('pengembalian.kelola')
                    <li class="nav-item">
                        <a class="nav-link text-nowrap px-3 {{ request()->routeIs('koreksi.pengembalian.*') ? 'fw-bold' : 'fw-semibold' }}" 
                           style="color: {{ request()->routeIs('koreksi.pengembalian.*') ? '#0c4a6e' : '#0369a1' }}; font-size: 15px;" 
                           href="{{ route('koreksi.pengembalian.daftar') }}">
                            Data Pengembalian
                        </a>
                    </li>
                @endcan

                {{-- PERSETUJUAN PEMINJAMAN --}}
                @can('peminjaman.setujui')
                @unless(auth()->user()->hasRole('admin'))
                    <li class="nav-item">
                        <a class="nav-link text-nowrap px-3 {{ request()->routeIs('persetujuan.*') ? 'fw-bold' : 'fw-semibold' }}" 
                           style="color: {{ request()->routeIs('persetujuan.*') ? '#0c4a6e' : '#0369a1' }}; font-size: 15px;" 
                           href="{{ route('persetujuan.antrian') }}">
                            Persetujuan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-nowrap px-3 {{ request()->routeIs('pemantauan.*') ? 'fw-bold' : 'fw-semibold' }}" 
                           style="color: {{ request()->routeIs('pemantauan.*') ? '#0c4a6e' : '#0369a1' }}; font-size: 15px;" 
                           href="{{ route('pemantauan.index') }}">
                            Pemantauan
                        </a>
                    </li>
                @endunless
                @endcan

                {{-- PENGEMBALIAN --}}
                @can('pengembalian.pantau')
                    <li class="nav-item">
                        <a class="nav-link text-nowrap px-3 {{ request()->routeIs('pengembalian.pantau') ? 'fw-bold' : 'fw-semibold' }}" 
                           style="color: {{ request()->routeIs('pengembalian.pantau') ? '#0c4a6e' : '#0369a1' }}; font-size: 15px;" 
                           href="{{ route('pengembalian.pantau') }}">
                            Pengembalian
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-nowrap px-3 {{ request()->routeIs('pengembalian.antrian') ? 'fw-bold' : 'fw-semibold' }}" 
                           style="color: {{ request()->routeIs('pengembalian.antrian') ? '#0c4a6e' : '#0369a1' }}; font-size: 15px;" 
                           href="{{ route('pengembalian.antrian') }}">
                            Verifikasi
                        </a>
                    </li>
                @endcan

                {{-- KATALOG, KERANJANG, & PEMINJAMAN SAYA --}}
                @can('alat.lihat')
                    <li class="nav-item">
                        <a class="nav-link text-nowrap px-3 {{ request()->routeIs('katalog.*') ? 'fw-bold' : 'fw-semibold' }}" 
                           style="color: {{ request()->routeIs('katalog.*') ? '#0c4a6e' : '#0369a1' }}; font-size: 15px;" 
                           href="{{ route('katalog.daftar') }}">
                            Katalog Alat
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-nowrap px-3 {{ request()->routeIs('katalog.keranjang') ? 'fw-bold' : 'fw-semibold' }}" 
                           style="color: {{ request()->routeIs('katalog.keranjang') ? '#0c4a6e' : '#0369a1' }}; font-size: 15px;" 
                           href="{{ route('katalog.keranjang') }}">
                            Keranjang
                            @if (count(session('keranjang', [])) > 0)
                                <span class="badge rounded-pill bg-warning text-dark ms-1">
                                    {{ count(session('keranjang', [])) }}
                                </span>
                            @endif
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-nowrap px-3 {{ request()->routeIs('peminjaman.saya') ? 'fw-bold' : 'fw-semibold' }}" 
                           style="color: {{ request()->routeIs('peminjaman.saya') ? '#0c4a6e' : '#0369a1' }}; font-size: 15px;" 
                           href="{{ route('peminjaman.saya') }}">
                            Peminjaman Saya
                        </a>
                    </li>
                @endcan

                {{-- LAPORAN --}}
                @can('laporan.cetak')
                    <li class="nav-item">
                        <a class="nav-link text-nowrap px-3 {{ request()->routeIs('laporan.*') ? 'fw-bold' : 'fw-semibold' }}" 
                           style="color: {{ request()->routeIs('laporan.*') ? '#0c4a6e' : '#0369a1' }}; font-size: 15px;" 
                           href="{{ route('laporan.form') }}">
                            Laporan
                        </a>
                    </li>
                @endcan

                {{-- PENGATURAN --}}
                @can('pengaturan.kelola')
                    <li class="nav-item">
                        <a class="nav-link text-nowrap px-3 {{ request()->routeIs('pengaturan.*') ? 'fw-bold' : 'fw-semibold' }}" 
                           style="color: {{ request()->routeIs('pengaturan.*') ? '#0c4a6e' : '#0369a1' }}; font-size: 15px;" 
                           href="{{ route('pengaturan.form') }}">
                            Pengaturan
                        </a>
                    </li>
                @endcan

            </ul>

            {{-- USER LOGOUT --}}
            @auth
                <div class="d-flex align-items-center gap-3 ms-auto mt-2 mt-lg-0">
                    <div class="text-lg-end text-nowrap">
                        <small class="d-block" style="font-size: 11px; line-height: 1.2; color: #0284c7;">Login sebagai</small>
                        <span class="fw-bold" style="font-size: 15px; color: #0c4a6e;">{{ auth()->user()->nama }}</span>
                    </div>

                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-sm border-0 fw-bold px-3 py-2 rounded-pill shadow-sm" style="background-color: #ffffff; color: #0284c7; font-size: 14px;">
                            Keluar
                        </button>
                    </form>
                </div>
            @endauth

        </div>
    </div>
</nav>