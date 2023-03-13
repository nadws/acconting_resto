@extends('theme.app')
@section('content')
    <div id="main" x-data="{
        permissionButton: [],
        namaPermission: '',
        idPermission: '',
        showDetail: function(id, namaPermission) {
            this.namaPermission = namaPermission
            this.idPermission = id
    
            axios.get(`/permission_gudang/${id}`)
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

                                <table class="table table-hover table-lg" id="table">
                                    <thead>
                                        <tr>
                                            <th width="5%">ID</th>
                                            <th>Nama Permission</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($permissionHalaman as $no => $d)
                                            <tr>
                                                <td>{{ $d->id_permission }}</td>
                                                <td style="cursor:pointer" @click="showDetail({{ $d->id_permission }}, '{{ $d->nm_permission }}')">{{ $d->nm_permission }}</td>
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
            <x-modal :title="$title" id="tambah" btnSave="Y" size="modal-lg">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Nama Permission</label>
                            <input required type="text" name="nm_permission" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Url</label>
                            <input required type="text" name="url" class="form-control">
                        </div>
                    </div>
                </div>

                <x-multiple-input>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Nama Butoon & Icon</label>
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
            </x-modal>
        </form>

        <form action="{{ route('permission_gudang.create') }}" method="post">
            @csrf
            <x-modal title="Detail {{ $title }}" id="detail" btnSave="Y" size="modal-lg">
                <h5 x-text="namaPermission" class="text-center"></h5>
                <input type="hidden" name="detail" value="Y">
                <input type="hidden" name="id_permission_gudang" x-bind:value="idPermission">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>List Button</th>
                            <th>Jenis</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(d, i) in permissionButton">

                            <tr>
                                <td x-text="d.id_permission_button"></td>
                                <td>
                                    <input type="text" name="nm_button_detail[]" x-bind:value="d.nm_permission_button" class="form-control">
                                    <input type="hidden" name="id_permission_button[]" x-bind:value="d.id_permission_button" class="form-control">
                                </td>
                                <td >
                                    <select name="jenis[]" id="" class="form-control">
                                        <option x-bind:selected="d.jenis === 'create'" value="create">Create</option>
                                        <option x-bind:selected="d.jenis === 'read'" value="read">Read</option>
                                        <option x-bind:selected="d.jenis === 'update'" value="update">Update</option>
                                        <option x-bind:selected="d.jenis === 'delete'" value="delete">Delete</option>
                                    </select>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
                <x-multiple-input>
                    <input type="hidden" name="tambah_row" value="Y">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Nama Butoon & Icon</label>
                            <input type="text" name="nm_button_row[]" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Jenis</label>
                            <select name="jenis_row[]" id="" class="form-control">
                                <option value="">- Pilih Jenis -</option>
                                <option value="create">Create</option>
                                <option value="read">Read</option>
                                <option value="update">Update</option>
                                <option value="delete">Delete</option>
                            </select>
                        </div>
                    </div>
                </x-multiple-input>
            </x-modal>
        </form>
    </div>
@endsection
