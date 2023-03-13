<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>




    <link rel="stylesheet" href="{{ asset('theme') }}/assets/css/main/app.css">

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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">


    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        body {
            font-family: 'Roboto', sans-serif;


        }

        .form-switch2 .form-check-input2 {
            background-image: url(data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3E%3Ccircle r='3' fill='rgba(0, 0, 0, 0.25)'/%3E%3C/svg%3E);
background-position: 0;
            border-radius: 2em;
            margin-left: -2.5em;
            transition: background-position .15s ease-in-out;
            width: 40px;
            transform: scale(1.5);
            margin-top: 8px;
            margin-left: -22px;
        }

        .modal-lg-max {
            max-width: 1200px;
        }
        
        .modal-lg-max2 {
            max-width: 1350px;
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
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        $(document).ready(function() {



            // $(document).on('click', '.remove_baris', function(e) {
            //     e.preventDefault()
            //     var delete_row = $(this).attr('count');
            //     $('#baris' + delete_row).remove();
            // });

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
        $('#table').DataTable({
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
        $('#table2').DataTable({
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

        $('#tableScroll').DataTable({
            "searching": true,
            scrollY: '400px',
            scrollCollapse: true,
            "autoWidth": true,
            "paging": false,
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
                    close: true,
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
                    close: true,
                    avatar: "https://cdn-icons-png.flaticon.com/512/564/564619.png"
                }).showToast();


            });
    </script>
    @endif
    @yield('scripts')
</body>

</html>