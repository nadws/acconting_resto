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
                        style="float: right; margin-right: 2px"><i class="fas fa-calendar-week"></i> View</a>
                </div>
                <div class="card-body">
                    <div id="tbl"></div>
                </div>
            </div>
        </section>
    </div>

</div>

{{-- edit sub kategori --}}
<form id="formView">
    <div class="modal fade text-left " id="view">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">
                        View
                    </h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Dari</label>
                                <input type="date" id="tgl1" name="tgl1" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Sampai</label>
                                <input type="date" id="tgl2" name="tgl2" class="form-control">
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
{{-- ------------------- --}}

{{-- form edit sub kategori --}}
<form id="formEditSubKategori">
    <div class="modal fade text-left " id="modalSubKategori">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">
                        Kategori
                    </h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="loadSubKategori">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="submit" class="btn btn-primary ml-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Edit</span>
                    </button>
                </div>

            </div>
        </div>
    </div>
</form>
{{-- ----------------- --}}

{{-- form tambah akun sub kategori --}}
<form id="formEditAkunSubKategori">
    <div class="modal fade text-left " id="modalAkunSubKategori">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">
                        Tambah Akun Sub Kategori
                    </h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="loadAkunSubKategori">

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
{{-- ----------------- --}}

{{-- detail akun --}}
<div class="modal fade text-left " id="modalDetailAkun">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">
                    Detail Akun
                </h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="loadDetailAkun">

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
{{-- ------- --}}
            
@endsection
@section('scripts')
<script>
    $(document).ready(function () {
        loadTabel()

        function loadTabel(tgl1 = "{{date('Y-m-1')}}", tgl2 = "{{date('Y-m-d')}}") {
            $.ajax({
                type: "GET",
                url: "{{route('loadTabel')}}",
                data : {
                    tgl1: tgl1,
                    tgl2: tgl2,
                },  
                success: function (r) {
                    $("#tbl").html(r);

                }
            });
        }

        function loadAkunSubKategori(id_kategori) {
            $.ajax({
                type: "GET",
                url: "{{route('loadAkunSubKategori')}}?id_kategori="+id_kategori,
                success: function (r) {
                    $("#loadAkunSubKategori").html(r);
                    $("#table3").DataTable({
                        scrollY: '200px',
                        scrollCollapse: true,
                        paging: false,
                    })
                }
            });
        }

        function loadSubKategori(jenis) {
            $.ajax({
                type: "GET",
                url: "{{route('loadSubKategori')}}?jenis="+jenis,
                success: function (r) {
                    $("#loadSubKategori").html(r);
                    $('.jenisSub').val(jenis)
                    $("#table2").DataTable({
                            "lengthChange": false,
                            "autoWidth": false,
                            "stateSave": true,
                        })
                }
            });
        }

        function loadDetailAkun(id_akun,id_kategori,kd_gabungan) {
            $.ajax({
                type: "GET",
                url: "{{route('loadDetailAkun')}}",
                data : {
                    id_akun : id_akun,
                    id_kategori : id_kategori,
                    kd_gabungan : kd_gabungan
                },
                success: function (r) {
                    $("#loadDetailAkun").html(r);
                    $("#tableDetailAkun").DataTable({
                            "lengthChange": false,
                            "autoWidth": false,
                            "stateSave": true,
                        })
                }
            });
        }

        function toast(pesan) {
            Toastify({
                text: pesan,
                duration: 3000,
                style: {
                    background: "#EAF7EE",
                    color: "#7F8B8B"
                },
                close:true,
                avatar: "https://cdn-icons-png.flaticon.com/512/190/190411.png"
            }).showToast();
        } 
        
        $(document).on('submit', '#formView', function(e){
            e.preventDefault()
            $('#view').modal('hide')
            var tgl1 = $("#tgl1").val()
            var tgl2 = $("#tgl2").val()

            loadTabel(tgl1, tgl2)
        })

        $(document).on('click', '.btnSubKategori', function(){
            $("#modalSubKategori").modal('show')
            var jenis = $(this).attr('jenis')
            loadSubKategori(jenis)
            
        })

        $(document).on('click', '#btnFormSubKategori', function(){
            var sub_kategori = $('#sub_kategori').val()
            var urutan = $('#urutan').val()
            var jenis = $('.jenisSub').val()
            $.ajax({
                type: "GET",
                url: "{{route('saveSubKategori')}}",
                data: {
                    sub_kategori:sub_kategori,
                    urutan:urutan,
                    jenis:jenis
                },
                success: function (r) {
                    toast('Berhasil tambah sub kategori')
                    loadSubKategori(jenis)
                    loadTabel()
                }
            });
        })

        $(document).on('submit', '#formEditSubKategori', function(e){
            e.preventDefault()
            var data = $("#formEditSubKategori").serialize()
            var jenis = $('.jenisSub').val()
            $.ajax({
                type: "GET",
                url: "{{route('editSubKategori')}}?"+data,
                success: function (response) {
                    toast('Berhasil edit sub kategori')
                    loadSubKategori(jenis)
                    loadTabel()
                    $("#modalSubKategori").modal('hide')
                }
            });
        })

        $(document).on('click', '.btnDeleteSubKategori', function(){
            var id = $(this).attr('id')
            $.ajax({
                type: "GET",
                url: "{{route('deleteSubKategori')}}?id="+id,
                success: function (r) {
                    toast('Berhasil hapus sub kategori')
                    loadSubKategori()
                    loadTabel()
                }
            });
        })

        $(document).on('click', '.btnSubKategoriAkun', function(){
            $("#modalAkunSubKategori").modal('show')
            var id_kategori = $(this).attr('id')
            loadAkunSubKategori(id_kategori)
        })

        $(document).on('submit', '#formEditAkunSubKategori', function(e){
            e.preventDefault()
            var id_akun = []
            var id_kategori = $('.checkAkun').attr('id_kategori')
            $("input:checkbox[name=type]:checked").each(function(){
                id_akun.push($(this).attr('id_akun'));
            });
            var jenis = $('.jenisSub').val()
            
            // var id_akun = $('.checkAkun').attr('id_akun')
            $.ajax({
                type: "GET",
                url: "{{route('saveAkunSubKategori')}}",
                data : {
                    id_akun : id_akun,
                    id_kategori : id_kategori,
                },
                success: function (response) {
                    toast('Berhasil tambah akun sub kategori')
                    loadSubKategori(jenis)
                    loadTabel()
                    $("#modalAkunSubKategori").modal('hide')
                }
            });
        })

        $(document).on('click', '.detailAkun', function(){
            var id_akun = $(this).attr('id_akun')
            var id_kategori = $(this).attr('id_kategori')
            var kd_gabungan = $(this).attr('kd_gabungan')
            $('#modalDetailAkun').modal('show')
            loadDetailAkun(id_akun,id_kategori,kd_gabungan)
        })
    });
</script>
@endsection