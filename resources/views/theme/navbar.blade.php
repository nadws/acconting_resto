<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">

                    <a href="{{route('dashboard')}}"><img
                            src="{{Session::get('id_lokasi') == '1' ? '/img/Takemori.svg' : '/img/soondobu.jpg'}}"
                            alt="" style="width: 80px; height: 80px;">
                    </a>
                </div>
                <div class=" theme-toggle d-flex gap-2 align-items-center mt-2">

                    <div class="form-check form-switch fs-6">
                        <input class="form-check-input  me-0" type="hidden" id="toggle-dark">
                        <label class="form-check-label"></label>
                    </div>

                </div>
                <div class="sidebar-toggler  x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu </li>
                <li class="sidebar-item">
                    <a href="{{route('dashboard')}}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                @if (in_array(auth()->user()->id, config('idBolehSet')))
                <li class="sidebar-item">
                    <a href="{{route('permission_gudang.index')}}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Permission Gudang</span>
                    </a>
                </li>
                @endif

                <li class="sidebar-item  has-sub">
                    <a href="#" class='sidebar-link'>
                        <i class="fas fa-warehouse"></i>
                        <span>Gudang</span>
                    </a>
                    <ul class="submenu ">
                        <li class="submenu-item ">
                            <a href="{{ route('sistem_po') }}">Pengajuan (PO)</a>
                            <a href="{{route('produk',1)}}">Bahan & Barang</a>
                        </li>

                    </ul>
                </li>

                <li class="sidebar-item  has-sub">
                    <a href="#" class='sidebar-link'>
                        <i class="fas fa-calculator"></i>
                        <span>Accounting</span>
                    </a>
                    <ul class="submenu">
                        <li class="submenu-item ">
                            <a href="{{route('jurnal_pemasukan')}}">Jurnal Pemasukan</a>
                        </li>
                        <li class="submenu-item">
                            <a href="{{route('jurnal_pengeluaran')}}">Jurnal Pengeluaran</a>
                        </li>
                        <li class="submenu-item">
                            <a href="{{route('buku_besar')}}">Buku Besar</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item has-sub">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-house-door-fill"></i>
                        <span>Homepage</span>
                    </a>
                    <ul class="submenu ">
                        <li class="submenu-item ">
                            <a href="{{route('cashflow')}}">Cashflow</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item has-sub">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-caret-down-square-fill"></i>
                        <span>More</span>
                    </a>
                    <ul class="submenu ">
                        <li class="submenu-item ">
                            <a href="{{route('akun')}}">Post Akun</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="{{route('user')}}">User</a>
                        </li>
                    </ul>
                </li>
                <br>
                <hr>
                <li class="sidebar-item  ">

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a type="submit" class='sidebar-link' onclick="event.preventDefault();
                        this.closest('form').submit();">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </a>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>