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
            <div class="row ">
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
        <form action="{{ route('save_pembelian_po_dimuka') }}" method="post">
            @csrf
            <section class="section">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3">
                                <label for="">Tanggal Beli</label>
                                <input type="date" name="tgl" class="form-control form-control-lg"
                                    value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-lg-3">
                                <label for="">Sub Po</label>
                                <input type="text" name="no_po" class="form-control form-control-lg" readonly
                                    value="{{ $sub_no_po }}">
                            </div>
                            <div class="col-lg-3">
                                <label for="">Pembeli</label>
                                <input type="text" name="pembeli" class="form-control form-control-lg" required>
                            </div>
                            <div class="col-lg-3">
                                <label for="">Tempat Beli</label>
                                <input type="text" name="tempat_beli" class="form-control form-control-lg" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">

                        <div class="card">
                            <div class="card-body">
                                <div class="">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Bahan</th>
                                                <th>Qty</th>
                                                <th>Satuan Beli</th>
                                                <th style="text-align: right">Rp Satuan</th>
                                                <th style="text-align: right">Total Rp</th>
                                            </tr>
                                        </thead>
                                        @php
                                        $totalRpSatuan = 0;
                                        @endphp
                                        <tbody>
                                            @foreach ($purchase as $no => $p)
                                            @php
                                            $totalRpSatuan += $p->ttl_rp;
                                            @endphp
                                            <input type="hidden" name="sub_no_po" value="{{ $p->sub_no_po }}">
                                            <tr>
                                                <td>
                                                    <label for="check{{ $no + 1 }}">{{ $p->nm_bahan }} </label>
                                                    <input type="hidden" name="id_purchase[]"
                                                        value="{{ $p->id_purchase }}">
                                                </td>
                                                <td>
                                                    {{ $p->qty }}
                                                </td>
                                                <td>
                                                    {{ $p->nm_satuan }}
                                                </td>
                                                <td align="right">
                                                    <span class="rpSatuan">{{ number_format($p->rp_satuan, 0) }}</span>
                                                </td>
                                                <td align="right">
                                                    <span class="rpSatuan">{{ number_format($p->ttl_rp, 0) }}</span>
                                                    <input type="hidden" name="rp_satuan[]" value="{{$p->ttl_rp}}">
                                                    <input type="hidden" name="id_bahan[]" value="{{$p->id_bahan}}">
                                                    <input type="hidden" name="id_satuan[]" value="{{$p->id_satuan}}">
                                                    <input type="hidden" name="qty[]" value="{{$p->qty}}">
                                                    <input type="hidden" name="id_purchase[]"
                                                        value="{{$p->id_purchase}}">
                                                </td>

                                            </tr>
                                            @endforeach

                                        </tbody>
                                        {{-- <tfoot>
                                            <tr>
                                                <th colspan="7">
                                                    <button type="button" class="btn btn-block btn-lg tbh_baris"
                                                        style="background-color: #F4F7F9; color: #8FA8BD; font-size: 14px; padding: 13px;">
                                                        <i class="fas fa-plus"></i> Tambah Biaya Lain - lain

                                                    </button>
                                                </th>
                                            </tr>
                                        </tfoot> --}}

                                    </table>
                                    <div class="row">
                                        <div class="col-lg-5">

                                        </div>
                                        <div class="col-lg-7">
                                            <hr style="border: 2px solid #435EBE;">
                                            <h6>Biaya lain : </h6>
                                            <br>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label for="">Pilih Akun</label>
                                                    <select name="id_akun[]" id="" class="select form-control">
                                                        <option value="">- Pilih Akun -</option>
                                                        @foreach ($akun as $l)
                                                        <option value="{{ $l->id_akun }}">{{ $l->nm_akun }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label for="">Rupiah</label>
                                                    <input name="rupiah[]" style="text-align: right" value="0"
                                                        type="text" class="form-control rpBiaya rpBiaya1">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label for="">Aksi</label> <br>
                                                    <button type="button" class="btn rounded-pill tbh_baris"
                                                        style="background-color: #F4F7F9; color: #8FA8BD;">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                                <div id="tb_stok"></div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label for="">Total</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    {{-- <input type="text" class="viewRpSatuan"
                                                        value="{{number_format($totalRpSatuan,0)}}"> --}}
                                                    <label for="" style="float:right" class="viewRpSatuan">Rp
                                                        {{ number_format($totalRpSatuan, 0) }}</label>
                                                </div>
                                                {{-- <input type="hidden" name="total_rp" value="{{$totalRpSatuan}}">
                                                --}}

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-5">

                                        </div>
                                        <div class="col-lg-7">
                                            <hr style="border: 2px solid #435EBE;">
                                            <h6>Pembayaran : </h6>
                                            <br>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label for="">Pilih Akun</label>
                                                    <select name="id_akun_pembayaran[]" id=""
                                                        class="select form-control">
                                                        <option value="">- Pilih Akun -</option>
                                                        @foreach ($akun2 as $l)
                                                        <option value="{{ $l->id_akun }}">{{ $l->nm_akun }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label for="">Rupiah</label>
                                                    <input name="rupiah_pembayaran[]" style="text-align: right"
                                                        value="0" type="text" class="form-control">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label for="">Aksi</label> <br>
                                                    <button type="button" class="btn rounded-pill tbh_baris_pembayaran"
                                                        style="background-color: #F4F7F9; color: #8FA8BD;">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                                <div id="tb_pembayaran"></div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" name="action" value="pasar" id="simpan" style=" margin-left: 8px;"
                                    class="btn float-end btn-primary">Simpan</button>
                                <a href="{{ route('cancel_pembelian',['sub_no_po' => $sub_no_po, 'no_po' => $no_po]) }}"
                                    style="float: right" class="btn btn-outline-primary">Batal</a>
                            </div>
                        </div>
                    </div>
                </div>

            </section>
        </form>
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

            function number(total) {
                var number_string = total.toString(),
                    sisa = number_string.length % 3,
                    rupiah = number_string.substr(0, sisa),
                    ribuan = number_string.substr(sisa).match(/\d{3}/g);
                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }
                return rupiah
            }

            $(".select").select2();
            var count = 1
            $(document).on('keyup', '.rpBiaya', function() {
                var total = "{{ $totalRpSatuan }}"
                var rupiah = 0
                $('.rpBiaya').each(function() {
                    rupiah += isNaN(parseInt($(this).val())) ? 0 : parseInt($(this).val());
                });
                rupiah = parseInt(rupiah)

                total = parseFloat(total) + parseFloat(rupiah)
                $('.viewRpSatuan').text('Rp. ' + number(total))
            })

            $(document).on('click', '.remove_baris', function(e) {
                e.preventDefault()
                var delete_row = $(this).attr('count');
                $('#baris' + delete_row).remove();

                var total = "{{$totalRpSatuan}}"
                var rupiah = 0
                $('.rpBiaya').each(function() {
                    rupiah += isNaN(parseInt($(this).val())) ? 0 : parseInt($(this).val());
                });
                rupiah = parseInt(rupiah)

                total = parseFloat(total) + parseFloat(rupiah)   
                $('.viewRpSatuan').text('Rp. '+number(total))
            });
            $(document).on('click', '.remove_baris_pembayaran', function(e) {
                e.preventDefault()
                var delete_row = $(this).attr('count');
                $('#baris' + delete_row).remove();
            });

            $(document).on('click', '.tbh_baris', function() {
                count = count + 1;
                $.ajax({
                    url: "{{ route('tambah_biaya_lain2') }}?count=" + count,
                    type: "Get",
                    success: function(data) {
                        $('#tb_stok').append(data);
                        $(".select").select2();
                    }
                });
            });
            $(document).on('click', '.tbh_baris_pembayaran', function() {
                count = count + 1;
                $.ajax({
                    url: "{{ route('tambah_biaya_lain3') }}?count=" + count,
                    type: "Get",
                    success: function(data) {
                        $('#tb_pembayaran').append(data);
                        $(".select").select2();
                    }
                });
            });
        });
</script>
@endsection