@extends('theme.app')
@section('content')
    <div id="main" x-data="{
        permissionButton: [],
        namaPermission: '',
        showDetail: function(id, namaPermission) {
            this.namaPermission = namaPermission
            axios.get(`/detail_permission/${id}`)
                .then(response => {
                    this.permissionButton = response.data
                    console.log(response.data)
                    $('#detail').modal('show');
                })
        }
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
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#tambah"
                                    class="btn icon icon-left btn-primary float-end me-2">
                                    <i class="fas fa-plus-circle"></i> Tambah
                                </a>
                            </div>
                            <div class="card-body">

                                <table class="table" id="table">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th>Nama Permission</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($permissionHalaman as $no => $d)
                                            <tr>
                                                <td>{{ $no + 1 }}</td>
                                                <td>{{ $d->nm_permission }}</td>
                                                <td>
                                                    <a @click="showDetail({{ $d->id_permission }}, '{{$d->nm_permission}}')" href="#"
                                                        id_halaman="{{ $d->id_permission }}"
                                                        class="btn btn-sm btn-primary detail"><i class="fas fa-eye"></i></a>
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

        <form action="{{ route('permission_gudang.create') }}" method="post">
            @csrf
            <div id="tambah" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel33">
                                Tambah {{ $title }}
                            </h4>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Nama Permission</label>
                                        <input type="text" name="nm_permission" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Url</label>
                                        <input type="text" name="url" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <x-multiple-input>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Nama Butoon</label>
                                        <input type="text" name="nm_button[]" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="">Jenis</label>
                                        <select name="jenis[]" id="" class="form-control">
                                            <option value="">- Pilih Jenis -</option>
                                            <option value="create">Create</option>
                                            <option value="read">Read</option>
                                            <option value="update">Update</option>
                                            <option value="delete">Delete</option>
                                        </select>
                                    </div>
                                </div>
                            </x-multiple-input>
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

        <x-modal :title="$title" id="detail" btnSave="true">
            <h5 x-text="namaPermission"></h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Button</th>
                        <th>Jenis</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="d in permissionButton">
                        <tr>
                            <td x-text="d.nm_permission_button"></td>
                            <td x-text="d.jenis"></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </x-modal>
    </div>
@endsection
