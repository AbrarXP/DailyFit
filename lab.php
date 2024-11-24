<!DOCTYPE html>
<html lang="en">

<?php
    session_start();
    

    if(!isset($_SESSION['userID'])){
        header('location:login/login.php?pesan=haruslogin');
    }else{
        include 'koneksi/cn.php';
    }

?>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>DailyFit</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!--Bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

    <!--Boxicon-->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


</head>

<body id="page-top">

    <?php
        if(isset($_GET['pesan']) && $_GET['pesan'] == 'login'){
        ?>
            <div class="alert border border-light alert-dismissible fade show" role="alert" id="loginAlert" style="width: 80vw;
                position:sticky; top:5%; left: 10%; z-index:1000;
                background: rgba(0,150,0,0.6);">
                <strong class="text-light">Selamat datang kembali, <?=$_SESSION['name']?></strong>
            </div>
            
            <script>
            // Menyembunyikan notifikasi setelah 5 detik
            setTimeout(function() {
                var alert = document.getElementById('loginAlert');
                alert.classList.remove('show');
                alert.classList.add('fade');
            }, 5000); // 5000 ms = 5 detik
        </script>
        <?php
        }
    ?>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">DailyFit</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Lab uji coba</span>
                </a>
            </li>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                         <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>


                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?=$_SESSION['name']?></span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a href="logout.php" style="color:black" class="dropdown-item"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400">Logout</i></a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->




                    <div class="row p-3">
                        <h1><strong>Lab Uji Coba</strong></h1>
                    </div>
                    
                    <!-- Catatan harian pengguna-->
                    <div class="row p-5 align-items-center shadow" style ="height:auto">
                        
                        <strong>Hash SHA256</strong>
                        <div class = "row border border-warning w-100 p-2 mb-3">
                            <div class="col-xl-3 border">
                                <form action="lab/hash.php" method ="POST">
                                    <label for="plaintext1">Plaintext</label>
                                    <input name="pt1" id="plaintext1" type="text" class ="form-control">
                                    
                                    <button class="btn btn-primary mt-1">Submit</button>
                                </form>
                            </div>
                            <div class="col-xl-9">
                                    <label for="plaintext1">Hash SHA256</label>
                                    <?php
                                        if(isset($_GET['pesan'])){
                                            ?>
                                            <input id="plaintext1" type="text" class ="form-control" readonly value="<?=$_GET['pesan']?>">
                                            <p>Panjang hash : <?=strlen($_GET['pesan'])?></p>
                                            <?php
                                        }else{
                                            ?>
                                            <input id="plaintext1" type="text" class ="form-control" readonly value="">
                                            <?php
                                        }
                                    ?>
                                    
                                    
                            </div>
                        </div>

                        <strong>Super enkripsi ( Caesaer + RC4)</strong>
                        <div class = "row border border-warning w-100 p-2 mb-3">
                            <div class="col-xl-3 border">
                                <form action="lab/superenkripsi.php" method ="POST">
                                    <label for="plaintext1">Plaintext</label>
                                    <input name="pt1" id="plaintext1" type="text" class ="form-control mb-3">
                                    <input name="key" id="plaintext1" type="number" class ="form-control mb-3" placeholder="key caesar">
                                    <input name="key2" id="plaintext1" type="text" class ="form-control mb-1" placeholder="key RC4">
                                    
                                    <button class="btn btn-primary mt-1">Submit</button>
                                </form>
                            </div>

                            <div class="col-xl-4">

                            <?php

                            ?>

                                    
                                    <label for="plaintext1">Caesar Cipher</label>
                                    <?php
                                        if(isset($_SESSION['pt'])){
                                            ?>
                                            <input id="plaintext1" type="text" class ="form-control" readonly value="<?=$_SESSION['pt']?>">
                                            <p>menggeser ASCII setiap karakter sesuai key</p>
                                            <?php
                                        }else{
                                            ?>
                                            <input id="plaintext1" type="text" class ="form-control" readonly value="">
                                            <?php
                                        }
                                    ?>
                                    
                                    
                            </div>

                            <div class="col-xl-4">

                                    
                                    <label for="">RC4</label>
                                    <?php
                                        if(isset($_SESSION['pt2'])){
                                            ?>
                                            <input type="text" class ="form-control" readonly value="<?=$_SESSION['pt2']?>">
                                            <br>
                                            (Encoded ke hexadesimal)
                                            <input type="text" class ="form-control" readonly value="<?=bin2hex($_SESSION['pt2'])?>">
                                            <?php
                                        }else{
                                            ?>
                                            <input id="plaintext1" type="text" class ="form-control" readonly value="">
                                            <?php
                                        }
                                    ?>
                                    
                                    
                            </div>
                        </div>
                        
                                    
                        <?php
                            if(isset($_SESSION['gambarAwal']) && isset($_SESSION['gambarAkhir']) && isset($_SESSION['catatan'])){
                                ?>

                                    <strong>Stegonografi LSB</strong>
                                    <div class = "row border border-warning w-100 p-2" style ="height:auto">
                                        <div class="col-xl-3 border">
                                            <form action="lab/lsb.php" method ="POST" enctype="multipart/form-data">
                                                

                                                <div class="mb-3">
                                                    <label>Upload Gambar</label>
                                                    <input class="form-control" type="file" id="progressImage" name="gambar" accept=".png" required>
                                                </div>
                                                <label for="plaintext1">Pesan</label>
                                                <input name="pt1" id="plaintext1" type="text" class ="form-control mb-3">
                                                
                                                <button class="btn btn-primary ">Submit</button>
                                            </form>
                                        </div>
                                        <div class="col-xl-9  p-4" style="width:40vw; height: auto">
                                            <?php  
                                                $base64img = $_SESSION['gambarAwal'];
                                                $base64imgLSB = $_SESSION['gambarAkhir'];
                                                $pesan = $_SESSION['catatan'];
                                            ?>

                                                <div class="row justify-content-center align-items-center " >
                                                    <div class="col-md-5  d-flex justify-content-center align-items-center">
                                                        <p>Gambar awal</p>
                                                    </div>
                                                    <div class="col-md-5  d-flex justify-content-center align-items-center">
                                                        <p>Gambar encoded LSB</p>
                                                    </div>
                                                </div> 
                                                <div class="row justify-content-center align-items-center  mb-3" style="min-height: 300px;">
                                                    <div class="col-md-5  d-flex justify-content-center align-items-center">
                                                    <img src="data:image/jpeg;base64,<?= $base64imgLSB ?>"  alt="Uploaded Raw Image" class="img-fluid">
                                                    </div>
                                                    <div class="col-md-5 d-flex justify-content-center align-items-center">
                                                    <img src="data:image/jpeg;base64,<?= $base64imgLSB ?>" alt="Uploaded Encoded Image" class="img-fluid">
                                                    </div>
                                                </div>


                                                    
                                                <div class="mb-4">
                                                    <label for="plaintext1">Stegonografi LSB (Encoded base64)</label>
                                                            <input id="plaintext1" type="text" class ="form-control" readonly value="<?=$base64imgLSB?>">
                                                            <p>Panjang encode base64 : <?=strlen($base64imgLSB)?></p>
                                                </div>

                                                <div>
                                                    <label for="plaintext1">Pesan yang di ekstrak dari gambar</label>
                                                            <input id="plaintext1" type="text" class ="form-control" readonly value="<?=$pesan?>">
                                                            <p>Panjang pesan : <?=strlen($pesan)?></p>
                                                </div>
                                                
                                        </div>
                            
                                

                                </div>

                                <?php
                            }else{
                                ?>

                                    <strong>Stegonografi LSB</strong>
                                    <div class = "row border border-warning w-100 p-2" style ="height:auto">
                                        <div class="col-xl-3 border">
                                            <form action="lab/lsb.php" method ="POST" enctype="multipart/form-data">
                                                

                                                <div class="mb-3">
                                                    <label>Upload Gambar</label>
                                                    <input class="form-control" type="file" id="progressImage" name="gambar" accept=".png" required>
                                                </div>
                                                <label for="plaintext1">Pesan</label>
                                                <input name="pt1" id="plaintext1" type="text" class ="form-control mb-3">
                                                
                                                <button class="btn btn-primary ">Submit</button>
                                            </form>
                                        </div>
                                        <div class="col-xl-9  p-4" style="width:40vw; height: auto">

                                                <div class="row justify-content-center align-items-center " >
                                                    <div class="col-md-5  d-flex justify-content-center align-items-center">
                                                        <p>Gambar awal</p>
                                                    </div>
                                                    <div class="col-md-5  d-flex justify-content-center align-items-center">
                                                        <p>Gambar encoded LSB</p>
                                                    </div>
                                                </div> 
                                                <div class="row justify-content-center align-items-center  mb-3" style="min-height: 300px;">
                                                    <div class="col-md-5  d-flex justify-content-center align-items-center">
                                                        <img src="temp_encoded_image.png" alt="Uploaded Image" class="img-fluid">
                                                    </div>
                                                    <div class="col-md-5 d-flex justify-content-center align-items-center">
                                                        <img src="temp_encoded_image.png" alt="Uploaded Image" class="img-fluid">
                                                    </div>
                                                </div>


                                                    
                                                <div class="mb-4">
                                                    <label for="plaintext1">Stegonografi LSB (Encoded base64)</label>
                                                    <?php
                                                        if(isset($_GET['pesan'])){
                                                            ?>
                                                            <input id="plaintext1" type="text" class ="form-control" readonly value="<?=$_GET['pesan']?>">
                                                            <p>Panjang encode base64 : <?=strlen($_GET['pesan'])?></p>
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <input id="plaintext1" type="text" class ="form-control" readonly value="">
                                                            <?php
                                                        }
                                                    ?>
                                                </div>

                                                <div>
                                                    <label for="plaintext1">Pesan yang di ekstrak dari gambar</label>
                                                    <?php
                                                        if(isset($_GET['pesan'])){
                                                            ?>
                                                            <input id="plaintext1" type="text" class ="form-control" readonly value="<?=$_GET['pesan']?>">
                                                            <p>Panjang encode base64 : <?=strlen($_GET['pesan'])?></p>
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <input id="plaintext1" type="text" class ="form-control" readonly value="">
                                                            <?php
                                                        }
                                                    ?>
                                                </div>
                                                
                                        </div>
                                </div>
                                <?php
                            }
                        ?>

                    
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2022</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="progressFormModal" tabindex="-1" aria-labelledby="progressFormModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="progressFormModalLabel">Tambah Progress</h5>
                    <button type="button" class="btn btn-outline-danger btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <!-- Form -->
                    <form action="submitProgress.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="progressImage" class="form-label">Upload Gambar</label>
                            <input class="form-control" type="file" id="progressImage" name="gambar" accept=".png" required>
                        </div>
                        <div class="mb-3">
                            <label for="progressValue" class="form-label">Tinggi Badan Saat Ini (CM)</label>
                            <input type="number" class="form-control" id="progressValue" name="tb" min="1" required>
                        </div>
                        <div class="mb-3">
                            <label for="progressValue" class="form-label">Berat Badan Saat Ini (KG)</label>
                            <input type="number" class="form-control" id="progressValue" name="bb" min="1" required>
                        </div>
                        <div class="mb-3">
                            <label for="progressText" class="form-label">Catatan Kebugaran</label>
                            <textarea class="form-control" id="progressText" name="catatan" rows="3" required></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
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

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

    

</body>

</html>