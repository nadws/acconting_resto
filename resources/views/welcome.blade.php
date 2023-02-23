<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Welcome</title>

    <style>
        .navbar {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: justify;
            justify-content: space-between;
            padding: 1.5rem 1rem;
        }

        .py-4 {
            padding-bottom: 2.5rem !important;
        }

        .bg-custome {
            background: linear-gradient(to right, #094067, #90b4ce);
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0, 0, 0, .12), 0 4px 8px rgba(0, 0, 0, .06);
        }

        a {
            color: #787878;
            text-decoration: none;
        }

        a:hover {
            color: #787878;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-light bg-custome">
        <div class="container-fluid">
            <a style="font-family: sans-serif; font-weight: 900; color: white;" class="navbar-brand"
                href="#">RESTAURANT</a>
        </div>
    </nav>
    <div class="container ">
        <br>
        <br>
        <h5 style="color: #129A8E; font-family: Arial, Helvetica, sans-serif; font-weight: bold;" class="text-center">
            "ACCOUNTING TAKEMORI & SOONDOBU"</h5>
        <br>
        <br>
        <br>
        <div class="row justify-content-center mt-6">
            <div class="col-lg-4 .col-6">
                <a href="{{route('login',['id_lokasi' => '1'])}}">
                    <div class="card shadow-lg" style="rou">
                        <div class="card-body text-center">
                            <img src="/img/Takemori.svg" class="img-fluid " alt="" width="80%">
                        </div>
                        <div class="card-footer">
                            <h5 class="text-center fw-bold">TAKEMORI</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 .col-6">
                <a href="">
                    <div class="card shadow-lg" style="rou">
                        <div class="card-body text-center">
                            <img src="/img/soondobu.jpg" class=" img-fluid" alt="" width=" 63%">
                        </div>
                        <div class="card-footer">
                            <h5 class="text-center fw-bold">SOONDOBU</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>