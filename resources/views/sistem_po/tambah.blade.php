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
        <form action="{{route('save_po')}}" method="post">
            @csrf
            <section class="section">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3">
                                <label for="">Tanggal</label>
                                <input type="date" name="tgl" class="form-control form-control-lg"
                                    value="{{date('Y-m-d')}}">
                            </div>
                            <div class="col-lg-3">
                                <label for="">No Po</label>
                                <input type="text" name="no_po" class="form-control form-control-lg" readonly
                                    value="PO{{$no_po}}">
                            </div>
                            <div class="col-lg-6">
                                <label for="">Keterangan</label>
                                <input type="text" name="ket" class="form-control form-control-lg">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th width="30%">Bahan</th>
                                    <th width="10%" style="text-align: right;">Qty</th>
                                    <th width="15%">Satuan Beli</th>
                                    <th width="15%" style="text-align: right;">Rp Satuan</th>
                                    <th width="20%" style="text-align: right;">Total Rp</th>
                                    <th width="5%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select name="id_bahan[]" id=""
                                            class="form-control  select_view id_bahan id_bahan1" detail='1'>
                                            <option value="">Pilih Bahan</option>
                                            @foreach ($list_bahan as $l)
                                            <option value="{{$l->id_list_bahan}}">{{$l->nm_bahan}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="qty[]" style="text-align: right;"
                                            class="form-control qty_beli qty_beli1" value="0" detail='1'>
                                    </td>
                                    <td>
                                        <select name="id_satuan[]" id="" class="form-control  select_view">
                                            <option value="">Pilih Satuan</option>
                                            @foreach ($satuan as $l)
                                            <option value="{{$l->id_satuan}}">{{$l->nm_satuan}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="h_satuan[]" style="text-align: right;"
                                            class="form-control h_satuan h_satuan1" value="0" detail='1'>
                                    </td>
                                    <td>
                                        <input type="number" name="ttl_rp[]" style="text-align: right;"
                                            class="form-control total1" value="0" readonly>
                                    </td>
                                    <td></td>
                                </tr>

                            </tbody>
                            <tbody id="tb_stok">

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="7">
                                        <button type="button" class="btn btn-block btn-lg tbh_baris"
                                            style="background-color: #F4F7F9; color: #8FA8BD; font-size: 14px; padding: 13px;">
                                            <i class="fas fa-plus"></i> Tambah Baris Baru

                                        </button>
                                    </th>
                                </tr>
                            </tfoot>


                        </table>
                    </div>
                    <div class="card-footer">
                        <button type="submit" style="float: right; margin-left: 8px;"
                            class="btn btn-primary">Simpan</button>
                        <a href="{{route('sistem_po')}}" style="float: right" class="btn btn-outline-primary">Batal</a>
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
        var count = 1;
        $(document).on('click', '.tbh_baris', function() {
            count = count + 1;
            $.ajax({
                url: "{{ route('tambah_baris_po') }}?count=" + count ,
                type: "Get",
                success: function(data) {
                    $('#tb_stok').append(data);
                    $(".select").select2();
                }
            });
        });
        $(document).on('click', '.remove_baris', function() {
                var delete_row = $(this).attr('count');

                $('#baris' + delete_row).remove();


        });
        $(document).on('change', '.id_bahan', function() {
                    var detail = $(this).attr('detail');
                    var id_bahan = $('.id_bahan' + detail).val();
                    $.ajax({
                    url: "{{ route('hrga_terakhir_po') }}?detail=" + detail + '&id_bahan=' + id_bahan,
                    type: "Get",
                    success: function(data) {
                        $('.h_satuan' + detail).val(data);
                        $(".select").select2();
                    }
                 });


        });
        $(document).on('change keyup', '.qty_beli', function() {
      
            var detail = $(this).attr('detail');
            var qty_beli = $('.qty_beli' + detail).val();
            var h_satuan = $('.h_satuan' + detail).val();  
            
            var total = parseFloat(qty_beli) * parseFloat(h_satuan);
            $('.total' + detail).val(total);
                
        });
        $(document).on('change keyup', '.h_satuan', function() {
      
            var detail = $(this).attr('detail');
            var qty_beli = $('.qty_beli' + detail).val();
            var h_satuan = $('.h_satuan' + detail).val();  
            
            var total = parseFloat(qty_beli) * parseFloat(h_satuan);
            $('.total' + detail).val(total);
                
        });
    });
</script>
@endsection