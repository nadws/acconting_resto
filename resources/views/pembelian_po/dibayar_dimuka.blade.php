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
            <form action="{{ route('save_pembelian_po_pasar') }}" method="post">
                @csrf
                <section class="section">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label for="">Tanggal Beli</label>
                                    <input type="date" name="tgl" class="form-control form-control-lg"
                                        value="{{ date('Y-m-d') }}" readonly>
                                </div>
                                <div class="col-lg-3">
                                    <label for="">No Po</label>
                                    <input type="text" name="no_po" class="form-control form-control-lg" readonly
                                        value="{{ $no_po }}">
                                </div>
                                <div class="col-lg-6">
                                    <label for="">Keterangan</label>
                                    <input type="text" name="ket" value="{{ $detail2->ket }}"
                                        class="form-control form-control-lg" readonly>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="">


                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>PEMBELIAN</th>
                                            <th colspan="3" style="text-align: center;">
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Bahan</th>
                                            <th>Qty</th>
                                            <th>Satuan Beli</th>
                                            <th style="text-align: right">Rp Satuan</th>
                                        </tr>
                                    </thead>
                                    @php
                                        $totalRpSatuan = 0;
                                    @endphp
                                    <tbody>
                                        @foreach ($purchase as $no => $p)
                                            @php
                                                $totalRpSatuan += $p->rp_satuan;
                                            @endphp
                                            <input type="hidden" name="sub_no_po" value="{{ $p->sub_no_po }}">
                                            <tr>

                                                <td>
                                                    <label for="check{{ $no + 1 }}">{{ $p->nm_bahan }}</label>
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
                                    <div class="col-lg-6">

                                    </div>
                                    <div class="col-lg-6">
                                        <hr>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label for="">Pilih Akun</label>
                                                <select required name="id_akun[]" id="" class="select form-control">
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
                                                <label for="">Aksi</label>
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
                                                {{-- <input type="text" class="viewRpSatuan" value="{{number_format($totalRpSatuan,0)}}"> --}}
                                                <label for="" style="float:right" class="viewRpSatuan">Rp
                                                    {{ number_format($totalRpSatuan, 0) }}</label>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" name="action" value="pasar" id="simpan"
                                style="float: right; margin-left: 8px;" class="btn btn-primary">Simpan</button>

                            <a href="{{ route('sistem_po') }}" style="float: right"
                                class="btn btn-outline-primary">Batal</a>
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
        });
    </script>
@endsection
