@extends('theme.app')
@section('content')
<style>
    .form-switch2 .form-check-input2 {
        background-image: url(data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3E%3Ccircle r='3' fill='rgba(0, 0, 0, 0.25)'/%3E%3C/svg%3E);
background-position: 0;
        border-radius: 2em;
        margin-left: -2.5em;
        transition: background-position .15s ease-in-out;
        width: 40px;
        transform: scale(2);
        margin-top: 8px;
        margin-left: -22px;
    }
</style>
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

            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-pills">

                        <li class="nav-item">
                            <a class="nav-link " aria-current="page" href="{{ route('produk',1) }}">Bahan &
                                barang</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('gudang') }}">Opname</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('kategori_bahan') }}">Kategori Bahan</a>
                        </li>
                    </ul>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#tambah" class="btn icon icon-left btn-primary"
                        style="float: right"><i class="bi bi-plus-circle"></i> Tambah</a>
                </div>
                <div class="card-body">

                    <table class="table table-striped" id="tb_bkin">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kategori </th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kategori as $no => $k)
                            <tr>
                                <td>{{$no+1}}</td>
                                <td>{{$k->nm_kategori}}</td>
                                <td>
                                    <a href="" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    <a onclick="return confirm('Yakin ingin dihapus ?')"
                                        href="{{ route('hapus_kategori_makanan', [$k->id_kategori_makanan, $k->jenis]) }}"
                                        class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>

                            @endforeach
                        </tbody>

                    </table>


                </div>
            </div>

        </section>
    </div>


    <style>
        .modal-lg-max2 {
            max-width: 900px;
        }
    </style>


    <div class="modal fade text-left" id="merk">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">
                        Merk {{$title}}
                    </h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div id="merk_bahan"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                </div>

            </div>
        </div>
    </div>

    <form action="{{route('save_kategori_makanan')}}" method="post">
        @csrf
        <div class="modal fade text-left" id="tambah">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">
                            {{$title}}
                        </h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="">Nama Kategori</label>
                                <input type="text" class="form-control" name="nm_kategori">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Save</span>
                        </button>
                    </div>

                </div>
            </div>
        </div>

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

@endsection