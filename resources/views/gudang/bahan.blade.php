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

    .choices__list--multiple .choices__item {
        display: inline-block;
        vertical-align: middle;
        border-radius: 20px;
        padding: 4px 10px;
        font-size: 12px;
        font-weight: 500;
        margin-right: 3.75px;
        margin-bottom: 3.75px;
        background-color: #3D56AD;
        border: 1px solid #3D56AD;
        color: #fff;
        word-break: break-all;
        box-sizing: border-box;
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
            <form action="{{route('save_opname')}}" method="post">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#tambah"
                            class="btn icon icon-left btn-primary" style="float: right"><i
                                class="bi bi-plus-circle"></i> Tambah</a>
                    </div>
                    <div class="card-body">

                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Merk Bahan</th>
                                    <th>Bahan</th>
                                    <th>Satuan</th>
                                    <th>Kategori</th>
                                    <th>Admin</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $no = 1;
                                @endphp
                                @foreach ($merkBahan as $j)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{$j->nm_merk}}</td>
                                    <td>{{$j->nm_bahan}}</td>
                                    <td>{{$j->nm_satuan}}</td>
                                    <td>{{$j->nm_kategori}}</td>
                                    <td>{{$j->admin}}</td>
                                    <td align="center">
                                        <a href="" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                        <a href="" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>

                        </table>


                    </div>
                </div>
            </form>
        </section>
    </div>

    <form action="{{route('save_merk_bahan')}}" method="post">
        @csrf
        <div class="modal fade text-left tambah" id="tambah">
            <div class="modal-dialog modal-lg" role="document">
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
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="list_kategori">Merk Bahan</label>
                                    <input type="text" name="nm_bahan" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="list_kategori">Nama Bahan</label>
                                    <select name="id_list_bahan[]" class="choices form-select multiple-remove"
                                        multiple="multiple">
                                        @foreach ($bahan as $b)
                                        <option value="{{$b->id_list_bahan}}">{{$b->nm_bahan}}</option>
                                        @endforeach
                                    </select>
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