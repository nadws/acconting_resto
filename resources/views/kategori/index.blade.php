@extends('theme.app')
@section('content')
<div id="main" x-data="{
        nama: '',
        id_kategori: '',
        edit: '',
    }">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $title }}</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">

            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-pills">

                        <li class="nav-item">
                            <a class="nav-link " aria-current="page" href="{{ route('produk', 1) }}">Bahan &
                                barang</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('gudang') }}">Opname</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('kategori_bahan') }}">Kategori Bahan</a>
                        </li>
                    </ul>
                    <x-btn-setting />

                    @if (!empty($create))
                    <a href="#" @click="nama = '';edit = ''" data-bs-toggle="modal" data-bs-target="#tambah"
                        class="me-2 btn icon icon-left btn-primary" style="float: right"><i
                            class="bi bi-plus-circle"></i> Tambah</a>
                    @endif
                </div>
                <div class="card-body">

                    <table class="table table-striped" id="table">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Kategori </th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kategori as $no => $k)
                            <tr>
                                <td>{{ $no + 1 }}</td>
                                <td><a href="#" class="click-add-bahan" id_kategori="{{ $k->id_kategori_makanan }}"
                                        data-bs-target="#viewAddBahan" data-bs-toggle="modal">{{ $k->nm_kategori }}</a>
                                </td>
                                <td>
                                    @if (!empty($update))
                                    <a href="#" data-bs-target="#tambah" data-bs-toggle="modal" @click="
                                                nama = '{{ $k->nm_kategori }}'; 
                                                id_kategori = '{{$k->id_kategori_makanan}}';
                                                edit = 'Y'" class="btn btn-warning btn-sm"><i
                                            class="fas fa-edit"></i></a>
                                    @endif

                                    @if (!empty($delete))
                                    <a onclick="return confirm('Yakin ingin dihapus ?')"
                                        href="{{ route('hapus_kategori_makanan', [$k->id_kategori_makanan, $k->jenis]) }}"
                                        class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>


                </div>
            </div>

        </section>
    </div>

    <form action="{{ route('save_kategori_makanan') }}" method="post">
        @csrf
        <x-modal id="tambah" title="Tambah {{ $title }}" btnSave="Y" size="">
            <div class="row">
                <div class="col-lg-12">
                    <input type="hidden" name="edit" :value="edit">
                    <input type="hidden" name="id_kategori_makanan" :value="id_kategori">

                    <label for="">Nama Kategori</label>
                    <input :value="nama" type="text" class="form-control" name="nm_kategori">
                </div>
            </div>
        </x-modal>
    </form>

    <form action="{{ route('save_permission') }}" method="post">
        @csrf
        <x-modal id="akses" title="Setting Akses" btnSave="Y" size="modal-lg-max">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Halaman</th>
                        <th>Create</th>
                        <th>Update</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user as $u)
                    @php
                    $akses = SettingHal::akses($halaman, $u->id);

                    $create = SettingHal::btnSetHal($halaman, $u->id, 'create');

                    $update = SettingHal::btnSetHal($halaman, $u->id, 'update');

                    $delete = SettingHal::btnSetHal($halaman, $u->id, 'delete');

                    @endphp
                    <input type="hidden" name="route" value="kategori_bahan">
                    <input type="hidden" name="id_permission_gudang" value="{{ $halaman }}">
                    <tr>
                        <td>{{ $u->nama }}</td>

                        <td>
                            <label><input type="checkbox" class="akses_h akses_h{{ $u->id }}" id_user="{{ $u->id }}"
                                    id_user="{{ $u->id }}" {{ empty($akses->id_permission_page) ? '' : 'Checked' }} />
                                Akses</label>
                            <input type="hidden" class="open_check{{ $u->id }}" name="id_user[]" {{
                                empty($akses->id_permission_page) ? 'disabled' : '' }}
                            value="{{ $u->id }}">
                        </td>
                        <td>


                            @foreach ($create as $c)
                            <label><input type="checkbox" name="id_permission{{ $u->id }}[]"
                                    value="{{ $c->id_permission_button }}" {{ empty($c->id_permission_page) ? '' :
                                'Checked' }}
                                class="open_check{{ $u->id }}"
                                {{ empty($akses->id_permission_page) ? 'disabled' : '' }} />
                                {!! $c->nm_permission_button !!}</label>
                            <br>
                            @endforeach
                        </td>
                        <td>

                            @foreach ($update as $r)
                            <label><input type="checkbox" name="id_permission{{ $u->id }}[]"
                                    value="{{ $r->id_permission_button }}" {{ empty($r->id_permission_page) ? '' :
                                'Checked' }}
                                class="open_check{{ $u->id }}"
                                {{ empty($akses->id_permission_page) ? 'disabled' : '' }} />
                                {!! $r->nm_permission_button !!}</label> <br>
                            @endforeach
                        </td>
                        <td>

                            @foreach ($delete as $r)
                            <label><input type="checkbox" name="id_permission{{ $u->id }}[]"
                                    value="{{ $r->id_permission_button }}" {{ empty($r->id_permission_page) ? '' :
                                'Checked' }}
                                class="open_check{{ $u->id }}"
                                {{ empty($akses->id_permission_page) ? 'disabled' : '' }} />
                                {!! $r->nm_permission_button !!}</label> <br>
                            @endforeach
                        </td>

                    </tr>
                    @endforeach

                </tbody>
            </table>
        </x-modal>
    </form>

    <form action="{{ route('save_add_bahan') }}" method="post">
        @csrf
        <x-modal id="viewAddBahan" title="Add Bahan {{ $title }}" btnSave="Y" size="modal-lg">
            <input id="searchBahan" type="text" placeholder="search..." class="form-control mb-5">
            <div id="load-add-bahan"></div>
        </x-modal>
    </form>
    <footer>
        <div class="footer clearfix mb-0 text-muted">
            <div class="float-start">
                <p>2021 &copy; Mazer</p>
            </div>
            <div class="float-end">
                <p>Agrika</p>
            </div>
        </div>
    </footer>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
            $(document).on('click', '.click-add-bahan', function(){
                var id_kategori = $(this).attr('id_kategori')
                $.ajax({
                    type: "GET",
                    url: "{{route('load_add_bahan')}}?id_kategori="+id_kategori,
                    success: function (r) {
                        $("#load-add-bahan").html(r);
                    }
                });
            })
            
            $("#searchBahan").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#tableBahan tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            $(document).on('click', '.akses_h', function() {
                var id_user = $(this).attr('id_user');
                if ($('.akses_h' + id_user).prop("checked") == true) {
                    $('.open_check' + id_user).removeAttr('disabled');
                } else {
                    $('.open_check' + id_user).prop('disabled', true);

                }

            });
        });
</script>
@endsection