<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}}</title>




    <link rel="stylesheet" href="{{ asset('theme') }}/assets/css/main/app.css">
    <link rel="stylesheet" href="{{ asset('theme') }}/assets/css/main/app-dark.css">
    <link rel="shortcut icon" href="{{ asset('theme') }}/assets/images/logo/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('theme') }}/assets/images/logo/favicon.png" type="image/png">

    <link rel="stylesheet" href="{{ asset('theme') }}/assets/css/pages/fontawesome.css">
    <link rel="stylesheet"
        href="{{ asset('theme') }}/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="{{ asset('theme') }}/assets/css/pages/datatables.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('theme') }}/assets/extensions/choices.js/public/assets/styles/choices.css">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('theme') }}/assets/extensions/toastify-js/src/toastify.css">



    <style>
        .modal-lg-max {
            max-width: 1200px;
        }
        .modal-md {
            max-width: 700px;
        }

        .select2 {
            width: 100% !important;

        }

        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 1px solid rgb(237, 238, 241);
            border-radius: 4px;
            height: 35px;
        }

        input:read-only {
            background-color: #E9ECEF;
        }

        input:active {
            background-color: #E9ECEF;
        }
    </style>
    @yield('styles')
</head>

<body>
    <div id="app">
        @include('theme.navbar')
        @yield('content')

    </div>
    <script src="{{ asset('theme') }}/assets/js/bootstrap.js"></script>
    <script src="{{ asset('theme') }}/assets/js/app.js"></script>

    <script src="{{ asset('theme') }}/assets/extensions/jquery/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
    <script src="{{ asset('theme') }}/assets/js/pages/datatables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script src="{{ asset('theme') }}/assets/extensions/choices.js/public/assets/scripts/choices.js"></script>
    <script src="{{ asset('theme') }}/assets/js/pages/form-element-select.js"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    {{-- <script src="{{ asset('theme') }}/assets/js/select2.min.js"></script> --}}
    <script src="{{ asset('theme') }}/assets/extensions/toastify-js/src/toastify.js"></script>



    <script>
        $(document).ready(function () {
            


            $(document).on('click', '.remove_baris', function(e) {
                e.preventDefault()
                var delete_row = $(this).attr('count');
                $('#baris' + delete_row).remove();
            });

            $('.select_view').select2();
             });
            $('.select2').select2({
                    dropdownParent: $('#tambah .modal-content')
            });
             $('#tb_bkin').DataTable({
                "paging": false,
                "pageLength": 100,
                "scrollY": "100%",
                "lengthChange": false,
                // "ordering": false,
                "info": false,
                "stateSave": true,
                "autoWidth": true,
                // "order": [ 5, 'DESC' ],
                "searching": true,
            });
    </script>
    @if (session()->has('sukses'))
    <script>
        $(document).ready(function() {
            Toastify({
                text: "{{ session()->get('sukses') }}",
                duration: 3000,
                style: {
                    background: "#EAF7EE",
                    color: "#7F8B8B"
                },
                close:true,
                avatar: "https://cdn-icons-png.flaticon.com/512/190/190411.png"
            }).showToast();
            });
    </script>
    @endif
    @if (session()->has('error'))
    <script>
        $(document).ready(function() {
            Toastify({
                text: "{{ session()->get('error') }}",
                duration: 3000,
                style: {
                    background: "#FCEDE9",
                    color: "#7F8B8B"
                },
                close:true,
                avatar: "https://cdn-icons-png.flaticon.com/512/564/564619.png"
            }).showToast();

            
            });
    </script>
    @endif
    @yield('scripts')
</body>

</html>