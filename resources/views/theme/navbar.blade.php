<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <a href="index.html">Takemori</a>
                </div>
                <div class="theme-toggle d-flex gap-2  align-items-center mt-2">

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
                <li class="sidebar-title">Menu</li>

                <li class="sidebar-item  ">
                    <a href="index.html" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item  has-sub">
                    <a href="#" class='sidebar-link'>
                        <i class="fas fa-warehouse"></i>
                        <span>Warehouse</span>
                    </a>
                    <ul class="submenu ">
                        <li class="submenu-item ">
                            <a href="{{route('produk')}}">Bahan</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="{{route('gudang')}}">Opname Bahan</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="{{route('merk_bahan')}}">Merk Bahan</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item  has-sub">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-stack"></i>
                        <span>Accounting</span>
                    </a>
                    <ul class="submenu ">
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
                <li class="sidebar-item  has-sub">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-menu-button-wide"></i>
                        <span>More</span>
                    </a>
                    <ul class="submenu ">
                        <li class="submenu-item ">
                            <a href="{{route('akun')}}">Post Akun</a>
                        </li>
                        {{-- <li class="submenu-item">
                            <a href="{{route('jurnal_pengeluaran')}}">Jurnal Pengeluaran</a>
                        </li>
                        <li class="submenu-item">
                            <a href="{{route('buku_besar')}}">Buku Besar</a>
                        </li> --}}

                    </ul>
                </li>




            </ul>
        </div>
    </div>
</div>