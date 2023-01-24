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

                    <h5>{{$akun->nm_akun}} <span style="font-size: 17px">( {{date('d-m-Y',strtotime($tgl1))}} ~
                            {{date('d-m-Y',strtotime($tgl2))}} )</span>
                    </h5>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Akun</th>
                                    <th>Keterangan</th>
                                    <th>Debit </th>
                                    <th>Kredit</th>
                                    <th>Saldo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($buku as $no => $j)
                                <tr>
                                    <td>{{$no+1}}</td>
                                    <td>{{$j->no_akun}}</td>
                                    <td>{{$j->ket}}</td>
                                    <td>{{number_format($j->debit,0)}}</td>
                                    <td>{{number_format($j->kredit,0)}}</td>
                                    <td>{{number_format($j->debit-$j->kredit,0)}}</td>
                                </tr>
                                @endforeach

                            </tbody>

                        </table>
                    </div>

                </div>
            </div>
        </section>
    </div>




    <footer>
        <div class="footer clearfix mb-0 text-muted">
            <div class="float-start">
                <p>2021 &copy; Agrika</p>
            </div>
            <div class="float-end">
                <p>Agrika</p>
            </div>
        </div>
    </footer>
</div>
@endsection