@extends('theme.app')
@section('content')
    <div id="main">
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
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link {{Request::is('kategoriMakanan/1') ? 'active' : ''}}"
                                            aria-current="page" href="{{ route('kategoriMakanan', 1) }}">Bahan</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{Request::is('kategoriMakanan/2') ? 'active' : ''}}"
                                            aria-current="page" href="{{ route('kategoriMakanan', 2) }}">Barang</a>
                                    </li>
                                </ul>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#tambah"
                                    class="btn icon icon-left btn-primary" style="float: right"><i class="bi bi-plus-circle"></i>
                                    Tambah</a>
                            </div>
                            <div class="card-body">
        
                                <table class="table" id="table1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Kategori Makanan</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kat as $no => $d)
                                            <tr>
                                                <td>{{ $no + 1 }}</td>
                                                <td>{{ $d->nm_kategori }}</td>
                                                <td align="center">
                                                    <a href="#" class="btn btn-sm btn-warning editKategoriMakanan" nm_kategori="{{$d->nm_kategori}}" id_kategori_makanan="{{ $d->id_kategori_makanan }}"><i
                                                            class="fas fa-pen"></i></a>
                                                    
                                                        @php
                                                            $adaStok = DB::table('tb_list_bahan')->where('id_kategori_makanan', $d->id_kategori_makanan)->first();
                                                        @endphp
                                                        @if (empty($adaStok))
                                                        <a onclick="return confirm('Yakin ingin dihapus ?')" href="{{ route('hapus_kategori_makanan', [$d->id_kategori_makanan, $id_jenis]) }}" class="btn btn-sm btn-danger"><i
                                                            class="fas fa-trash-alt"></i></a>
                                                        @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
        
                                </table>
        
        
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <form action="{{route('save_kategori_makanan')}}" method="post">
        @csrf
        <div class="modal fade text-left tambah" id="tambah">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">
                            Tambah {{$title}}
                        </h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="hidden" name="id_jenis" value="{{ $id_jenis }}">
                                    <label for="list_kategori">Kategori Makanan</label>
                                    <input required autofocus type="text" name="nm_kategori" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" class="btn btn-primary ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Save</span>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </form>

    <form action="{{route('edit_kategori_makanan')}}" method="post">
        @csrf
        <div class="modal fade text-left tambah" id="edit">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">
                            Tambah {{$title}}
                        </h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="hidden" name="id_jenis" value="{{ $id_jenis }}">
                                    <input type="hidden" name="id_kategori_makanan" class="id_kategori_makanan">
                                    <label for="list_kategori">Kategori Makanan</label>
                                    <input required autofocus type="text" name="nm_kategori" class="form-control nm_kategori">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" class="btn btn-primary ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Save</span>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </form>
@endsection
@section('scripts')
<script>
    $(document).ready(function () {
        $(document).on('click', '.editKategoriMakanan', function(){
            var id_kategori_makanan = $(this).attr('id_kategori_makanan')
            var nm_kategori = $(this).attr('nm_kategori')
            $(".nm_kategori").val(nm_kategori)
            $(".id_kategori_makanan").val(id_kategori_makanan)
            
            $('#edit').modal('show')
        })
    });
</script>
@endsection