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
                    <a href="#" data-bs-toggle="modal" data-bs-target="#view" class="btn icon icon-left btn-primary "
                        style="float: right; margin-right: 2px"><i class="fas fa-calendar-week"></i> View
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Akun</th>
                                    <th>Nama Akun</th>
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
                                    <td><a
                                            href="{{route('detail_buku',['id_akun' => $j->id_akun,'tgl1' => $tgl1,'tgl2'=> $tgl2])}}">{{$j->nm_akun}}</a>
                                    </td>
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


    <style>
        .modal-lg-max2 {
            max-width: 1350px;
        }
    </style>
    <form action="{{ route('save_stok_daging')}}" method="post">
        @csrf
        <div id="tambah" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog  modal-lg-max2" role="document">
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
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="list_kategori">Tanggal</label>
                                    <input class="form-control" type="date" name="tgl" id="tgl_peng"
                                        value="<?= date('Y-m-d') ?>" required>

                                </div>
                            </div>
                            <div class="col-1">
                                <div class="mt-3 ml-1 ">
                                    <p class="mt-4 ml-2 text-warning"><strong>Db</strong></p>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="list_kategori">Akun</label>
                                    <select name="id_akun" id="id_pilih" class="choices form-select id_dipilih"
                                        required="">
                                        <option value="">- Pilih Akun -</option>
                                        @foreach ($akun as $ak)
                                        <option value="{{ $ak->id_akun }}">{{ $ak->nm_akun }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>

                            <div class="col-sm-2 col-md-2">
                                <div class="form-group">
                                    <label for="list_kategori">Debit</label>
                                    <input type="number" class="form-control total " id="total" name="total" readonly>
                                </div>
                            </div>
                            <div class="col-sm-2 col-md-2">
                                <div class="form-group">
                                    <label for="list_kategori">Kredit</label>
                                    <input type="number" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-sm-3 col-md-3">
                                <!-- <div class="form-group">
                                  <input class="form-control" type="text" name="no_urutan" placeholder="Nomor id" required>
                                </div> -->
                            </div>
                            <div class="col-1">
                                <div class="mt-1">
                                    <p class="mt-1 ml-3 text-warning"><strong>Cr</strong></p>
                                </div>
                            </div>

                            <div class="col-sm-3 col-md-3">
                                <div class="form-group">
                                    <select name="metode" id="metode" class="choices form-select" required="">
                                        <option value="" data-select2-id="13">-Pilih Akun-</option>
                                        @foreach ($akun as $a)
                                        <option value="{{$a->id_akun}}">{{$a->nm_akun}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2 col-md-2">
                                <div class="form-group">
                                    <input type="number" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-sm-2 col-md-2">
                                <div class="form-group">

                                    <input type="number" class="form-control total" id="total1" disabled>
                                </div>
                            </div>

                            <div id="input_jurnal">

                            </div>

                            <div id="biaya_lain">

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
    <form action="" method="get">
        <div id="view" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog  " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">
                            View {{$title}}
                        </h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="list_kategori">Dari</label>
                                    <input class="form-control" type="date" name="tgl1" value="<?= date('Y-m-d') ?>"
                                        required>

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="list_kategori">Sampai</label>
                                    <input class="form-control" type="date" name="tgl2" value="<?= date('Y-m-d') ?>"
                                        required>

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
                <p>2021 &copy; Agrika</p>
            </div>
            <div class="float-end">
                <p>Agrika</p>
            </div>
        </div>
    </footer>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {

        $(document).on('change', '.id_dipilih', function() {
            var id_debit = $(this).val();
           
            $.ajax({
                    url: "{{ route('get_isi_jurnal') }}",
                    data: {
                        id_debit: id_debit,
                    },
                    type: "GET",
                    success: function(data) {
                        $('#input_jurnal').html(data);
                        $(".select").select2({
                            dropdownParent: $('#tambah .modal-content')
                        });
                    }
            });

            
           


        });
        $(document).on('change', '.listBahan', function() {
            var count = $(this).attr('detail');
            var id_list_bahan = $('.listBahan' + count).val();
            $.ajax({
                    url: "{{ route('get_satuan_bahan') }}",
                    data: {
                        id_list_bahan: id_list_bahan,
                    },
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $("#satuanResep" + count).val(data.satuan)
                        $("#idSatuanResep" + count).val(data.id_satuan)
                        $(".select").select2({
                            dropdownParent: $('#tambah .modal-content')
                        });
                    }
            });

            $.ajax({
                    url: "{{ route('get_merk') }}",
                    data: {
                        id_list_bahan: id_list_bahan,
                    },
                    type: "GET",
                    success: function(data) {
                        $("#id_merk_bahan" + count).html(data);
                        $(".select").select2({
                            dropdownParent: $('#tambah .modal-content')
                        });
                    }
            });


        });

        $(document).on('keyup', '.total_rpDaging', function(){
            var ttl_rp = $(this).val();
            var count = $(this).attr('total_rp');
            var qty = $('.qty_monitoring' + count).val();
      

            var qty_r = parseFloat(qty * 1000);
            var qty_resep = $('.qtyResep' + count).val(qty_r);

            var ttl = parseFloat(ttl_rp * qty);

            var total = $('.t_rp' + count).val(ttl);
            var ppn = (ttl * 10) / 100;
            var pn = $('.ppn' + count).val(ppn);
            var d = ttl + ppn;

            var debit = 0;
                $(".t_rp:not([disabled=disabled]").each(function() {
                    debit += parseFloat($(this).val());
            });

            var ppn_total = 0;
                $(".ppn:not([disabled=disabled]").each(function() {
                    ppn_total += parseFloat($(this).val());
            });
        

            var biy_lain = 0;
                    $(".nom_lain:not([disabled=disabled]").each(function() {
                        biy_lain += parseFloat($(this).val());
                });

            var total_all = parseFloat(debit) + parseFloat(ppn_total) + + parseFloat(biy_lain);


            var debit = $('.total').val(total_all);
        
        });
        $(document).on('keyup', '.ppn', function(){
            var count = $(this).attr('total_rp');

            var ppn = $('.ppn' + count).val();
            var total = $('.t_rp' + count).val();
            var d = parseFloat(total)  + parseFloat(ppn);
            
            var debit = 0;
                $(".t_rp:not([disabled=disabled]").each(function() {
                    debit += parseFloat($(this).val());
            });

            var ppn_total = 0;
                $(".ppn:not([disabled=disabled]").each(function() {
                    ppn_total += parseFloat($(this).val());
            });

            var biy_lain = 0;
                    $(".nom_lain:not([disabled=disabled]").each(function() {
                        biy_lain += parseFloat($(this).val());
                });

            var total_all = parseFloat(debit) + parseFloat(ppn_total) + + parseFloat(biy_lain);


            var debit = $('.total').val(total_all);
            
        
        });

            var count = 1;
            $(document).on('click', '.tbh-stok', function() {
                count = count + 1;
                $.ajax({
                    url: "{{ route('tambah_jurnal_daging') }}?count=" + count,
                    type: "Get",
                    success: function(data) {
                        $('#tambah_input_jurnal').append(data);
                        $(".select").select2({
                            dropdownParent: $('#tambah .modal-content')
                        });
                    }
                });
            });
            
            $(document).on('click', '.remove_monitoring', function() {
                var delete_row = $(this).attr('count');

                $('#row' + delete_row).remove();

                var ppn = $('.ppn' + count).val();
                var total = $('.t_rp' + count).val();
                var d = parseFloat(total)  + parseFloat(ppn);
                
                var debit = 0;
                    $(".t_rp:not([disabled=disabled]").each(function() {
                        debit += parseFloat($(this).val());
                });

                var ppn_total = 0;
                    $(".ppn:not([disabled=disabled]").each(function() {
                        ppn_total += parseFloat($(this).val());
                });
                var biy_lain = 0;
                    $(".nom_lain:not([disabled=disabled]").each(function() {
                        biy_lain += parseFloat($(this).val());
                });

                var total_all = parseFloat(debit) + parseFloat(ppn_total) + + parseFloat(biy_lain);


                var debit = $('.total').val(total_all);
            

            });
            $(document).on('click', '.onlain', function() {
                if($(this).prop("checked") == true){
                    $('#biaya_lain').show();
                    $('.inp-lain').removeAttr('disabled');
                    $.ajax({
                    url: "{{ route('get_biaya_lain') }}",
                    type: "GET",
                    success: function(data) {
                        $('#biaya_lain').html(data);
                        $(".select").select2({
                            dropdownParent: $('#tambah .modal-content')
                        });
                    }
            });
                }
                else if($(this).prop("checked") == false){
                    $('#biaya_lain').hide();
                    $('.inp-lain').attr('disabled', 'true');
                }
                
            });
            var count = 1;
            $(document).on('click', '.tbh-lain', function() {
                count = count + 1;
                $.ajax({
                    url: "{{ route('tambah_jurnal_lain') }}?count=" + count,
                    type: "Get",
                    success: function(data) {
                        $('#tambah_biaya_lain').append(data);
                        $(".select").select2({
                            dropdownParent: $('#tambah .modal-content')
                        });
                    }
                });
            });
            $(document).on('click', '.remove_lain', function() {
                var delete_row = $(this).attr('count');

                $('#lain' + delete_row).remove();

                var debit = 0;
                    $(".t_rp:not([disabled=disabled]").each(function() {
                        debit += parseFloat($(this).val());
                });

                var ppn_total = 0;
                    $(".ppn:not([disabled=disabled]").each(function() {
                        ppn_total += parseFloat($(this).val());
                });

                var biy_lain = 0;
                    $(".nom_lain:not([disabled=disabled]").each(function() {
                        biy_lain += parseFloat($(this).val());
                });



                var total_all = parseFloat(debit) + parseFloat(ppn_total) + + parseFloat(biy_lain);


                var debit = $('.total').val(total_all);

            });
            $(document).on('keyup', '.nom_lain', function() {
                
                var debit = 0;
                    $(".t_rp:not([disabled=disabled]").each(function() {
                        debit += parseFloat($(this).val());
                });

                var ppn_total = 0;
                    $(".ppn:not([disabled=disabled]").each(function() {
                        ppn_total += parseFloat($(this).val());
                });

                var biy_lain = 0;
                    $(".nom_lain:not([disabled=disabled]").each(function() {
                        biy_lain += parseFloat($(this).val());
                });



                var total_all = parseFloat(debit) + parseFloat(ppn_total) + + parseFloat(biy_lain);


                var debit = $('.total').val(total_all);

            });
    });
</script>



@endsection