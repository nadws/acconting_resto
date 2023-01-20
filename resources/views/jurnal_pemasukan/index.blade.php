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
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"></h4>
                </div>
                <div class="card-body">

                    <table class="table" id="kunjungan">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>No Invoice</th>
                                <th>Keterangan</th>
                                <th>No Akun</th>
                                <th>Nama Akun</th>
                                <th>Debit </th>
                                <th>Kredit </b></th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>

                    </table>


                </div>
            </div>
        </section>
    </div>

    <footer>
        <div class="footer clearfix mb-0 text-muted">
            <div class="float-start">
                <p>2021 &copy; Mazer</p>
            </div>
            <div class="float-end">
                <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a
                        href="https://saugi.me">Saugi</a></p>
            </div>
        </div>
    </footer>
</div>
@endsection

@section('scripts')


<script>
    $(document).ready(function() {
        $('#kunjungan').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("data_pemasukan") }}',
            columns: [
                {
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                {data: 'tgl', name: 'tgl'},
                {data: 'kd_gabungan', name: 'kd_gabungan'},
                {data: 'ket', name: 'ket'},
                {data: 'no_akun', name: 'no_akun'},
                {data: 'nm_akun', name: 'nm_akun'},
                {data: 'debit', name: 'debit', render: $.fn.dataTable.render.number( ',', '.', 0, '' )},
                {data: 'kredit', name: 'kredit', render: $.fn.dataTable.render.number( ',', '.', 0, '' )}
            ]
        });
            
        });
</script>
@endsection