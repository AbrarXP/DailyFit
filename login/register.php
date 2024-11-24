<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>DailyFit Register</title>

    <!-- Custom fonts for this template-->

    <link rel="icon" href="../img/logo2.png">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


</head>

<body class="bg-gradient-primary">
        <?php
        if(isset($_GET['pesan']) && $_GET['pesan'] == 'unmatched'){
        ?>
            <div class="alert border border-light alert-dismissible fade show" role="alert" style="width: 80vw;
                position:sticky; top:5%; left: 10%; z-index:1000;
                background: rgba(210,0,0,0.6);">
                <strong class="text-light">Pastikan password dan konfirmasi password sama !</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php
        }else if(isset($_GET['pesan']) && $_GET['pesan'] == 'terdaftar'){
        ?>
            <div class="alert border border-light alert-dismissible fade show" role="alert" style="width: 80vw;
                position:sticky; top:5%; left: 10%; z-index:1000;
                background: rgba(210,0,0,0.6);">
                <strong class="text-light">Username sudah terdaftar !</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php
        }else if(isset($_GET['pesan']) && $_GET['pesan'] == 'kosong'){
        ?>
            <div class="alert border border-light alert-dismissible fade show" role="alert" style="width: 80vw;
                position:sticky; top:5%; left: 10%; z-index:1000;
                background: rgba(210,0,0,0.6);">
                <strong class="text-light">Semua field harus terisi !</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php
        }
        ?>

    <div class="container" style="margin-top: 5vh">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"><img src="../img/4.png" alt="" style="object-fit:cover;filter: brightness(0.5); width:100%; height:100%"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Selamat Datang, DailyFiters!</h1>
                                    </div>
                                    <form class="user" action="prosesRegister.php" method="post">
                                    <div class="form-group">
                                            <input name ="user" type="text" class="form-control form-control-user"
                                                id="exampleInputEmail" 
                                                placeholder="Enter Your Username">
                                        </div>
                                        <div class="form-group">
                                            <input name ="email" type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address">
                                        </div>
                                        <div class="form-group">
                                            <input name ="password" type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <input name ="password2" type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Confirm Your Password">
                                        </div>
                                        <button class="btn btn-primary btn-user btn-block">
                                            Register
                                        </button>
                                        <hr>
                                    </form>
                                    <div style="font-size: 11px" class="text-center">
                                        Username dan password di diamankan menggunakan hash SHA256
                                    </div>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="login.php">Sudah punya akun ?</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  

</body>

</html>