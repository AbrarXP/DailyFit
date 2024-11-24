<!DOCTYPE html>
<html lang="en">

<?php
    session_start();
    

    if(!isset($_SESSION['userID'])){
        header('location:login/login.php?pesan=haruslogin');
    }else{
        include 'submitProgress.php';
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
                <a class="nav-link" href="index.html">
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
                <a class="nav-link collapsed" href="lab.php">
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


                <?php   

                        $key = 3;
                        $key2 = "selamaSingaBelumBisaMenulisSemuaCeritaAkanMengagungkanSangPemburu";


                        $UID = $_SESSION['userID'];
                        $data = mysqli_query($cn, "SELECT * FROM progress where userID = '$UID' ORDER BY time DESC LIMIT 1;");

                        $bbNav = 50;
                        $tbNav = 50;

                        $cek = mysqli_num_rows($data);
                        if($cek > 0){
                            $hasil = mysqli_fetch_array($data);

                            $tbNav = $hasil['tinggi_badan'];
                            $bbNav = $hasil['berat_badan'];

                            $tbNav = base64_decode($tbNav);
                            $tbNav = rc4($key2, $tbNav);
                            $tbNav = caesarCipher($tbNav, -$key);

                            $bbNav = base64_decode($bbNav);
                            $bbNav = rc4($key2, $bbNav);
                            $bbNav = caesarCipher($bbNav, -$key);
                        }


                ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Content Row ata BB, TB, BMI-->
                    <div class="row justify-content-center align-items-center">

                        <!-- Earnings (Monthly) Card Example -->
                        <!-- Card dengan Tombol -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2 p-2">
                                <div class="card-body d-flex align-items-center justify-content-center p-0" style="height: 100%;">
                                    <div class="text-center w-100">
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-3">
                                            Tambah Progress mu!
                                        </div>
                                        <button type="button" class="btn btn-outline-danger w-75 h-100" data-bs-toggle="modal" data-bs-target="#progressFormModal">
                                            <i class='bx bx-plus-medical' style="font-size: 2rem;"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Berat Badan</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$bbNav?> KG</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class='bx bx-male bx-lg'></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Tinggi Badan</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$tbNav?> CM</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class='bx bx-ruler bx-lg'></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->

                        <?php
                            $tbNav = $tbNav / 100;

                            // Hitung BMI
                            $bmi = $bbNav / ($tbNav ** 2);
                            $bmi = round($bmi, 2)
   

                        ?>
                        <div class="col-xl-3 col-md-6 mb-4">

                            <?php
                                 // Tentukan kategori BMI
                            if ($bmi < 18.5) {
                                ?>
                                    <div class="card border-left-danger shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-danger text-info text-uppercase">
                                                        BMI : Kekurangan Gizi
                                                    </div>
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col-auto">
                                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?=$bmi?></div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="progress progress-sm mr-2">
                                                                <div class="progress-bar bg-danger" role="progressbar"
                                                                    style="width: 25%" aria-valuenow="50" aria-valuemin="0"
                                                                    aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                <i class='bx bx-dizzy bx-tada bx-lg' ></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                            } elseif ($bmi >= 18.5 && $bmi <= 24.9) {
                                ?>
                                    <div class="card border-left-success shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-success text-info text-uppercase">
                                                        BMI : Normal
                                                    </div>
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col-auto">
                                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?=$bmi?></div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="progress progress-sm mr-2">
                                                                <div class="progress-bar bg-success" role="progressbar"
                                                                    style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                                                    aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                <i class='bx bx-wink-smile bx-tada bx-lg' ></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                            } elseif ($bmi >= 25 && $bmi <= 29.9) {
                                ?>
                                <div class="card border-left-warning shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-warning text-info text-uppercase">
                                                        BMI : Kelebihan Berat
                                                    </div>
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col-auto">
                                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?=$bmi?></div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="progress progress-sm mr-2">
                                                                <div class="progress-bar bg-warning" role="progressbar"
                                                                    style="width: 75%" aria-valuenow="50" aria-valuemin="0"
                                                                    aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                <i class='bx bx-confused bx-tada bx-lg' ></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                            } else {
                                ?>
                                    <div class="card border-left-danger shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-danger text-info text-uppercase">
                                                        BMI : Obesitas
                                                    </div>
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col-auto">
                                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?=$bmi?></div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="progress progress-sm mr-2">
                                                                <div class="progress-bar bg-danger" role="progressbar"
                                                                    style="width: 100%" aria-valuenow="50" aria-valuemin="0"
                                                                    aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                <i class='bx bx-dizzy bx-tada bx-lg' ></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                            }
                            ?>

                        </div>

                        
                    </div>


                        <div class="row p-3">
                            <h1><strong>Postingan terbaru</strong></h1>
                        </div>
                    
                    <!-- Catatan harian pengguna-->
                    <div class="row justify-content-center align-items-center shadow" style ="height:65vh">

                    <!-- ================================================   Illustrations kiri   ================================================-->
                        
                        <div class="col-lg-8 mb-4 p-3" style ="height:65vh; overflow-y:scroll">
                        
                            <?php 
                                $i = 0;
                                $query = mysqli_query($cn,"select * from progress");
                                date_default_timezone_set('Asia/Jakarta');
                                $cek = mysqli_num_rows($query);
                                if($cek > 0){

                                    $key = 3;
                                    $key2 = "selamaSingaBelumBisaMenulisSemuaCeritaAkanMengagungkanSangPemburu";

                                    $data = mysqli_query($cn, "SELECT * FROM progress ORDER BY time DESC");
                                    while($row = mysqli_fetch_array($data)) {
                                    
                                    // Mengambil nama user
                                    $userID = $row['userID'];
                                    $dataUser = mysqli_query($cn, "SELECT * FROM users where id = '$userID'");
                                    $rowUser = mysqli_fetch_array($dataUser);

                                    
                                    //Inisialiasi awal
                                    $username = $rowUser['username'];
                                    $tb = $row['tinggi_badan'];
                                    $bb = $row['berat_badan'];
                                    $gambar = $row['img'];
                                    $tanggal = $row['time'];

                                    // Waktu update progress
                                    $created_at = $tanggal;
                                    $current_time = time();
                                    $created_time = strtotime($created_at);

                                    $diff_seconds = $current_time - $created_time;
                                    // Mengubah gambar dari base64 menjadi biner kemudian meminta server host sementara gambar tersebut
                                    $gambar = base64_decode($gambar);
                                    $tempImagePath = 'temp_encoded_image'.$i++.'.png'; // Nama sementara untuk file
                                    file_put_contents($tempImagePath, $gambar);// Menyimpan data biner ke file
                                    
                                    // Proses pengeluaran pesan rahasia dari gambar
                                    $catatan = decodeLSB($tempImagePath);

                                    // proses dekrip superenkripsi 
                                    $catatan = rc4($key2, $catatan);
                                    $catatan = caesarCipher($catatan, -$key);
                                    
                                    $tb = base64_decode($tb);
                                    $tb = rc4($key2, $tb);
                                    $tb = caesarCipher($tb, -$key);
                                    
                                    $bb = base64_decode($bb);
                                    $bb = rc4($key2, $bb);
                                    $bb = caesarCipher($bb, -$key);



                            ?>
                                <!--=======================-->
                                <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between">
                                    <div class="d-flex gap-2 align-items-center">
                                        <!-- Tetapkan ukuran gambar tetap -->
                                        <img class="img-profile rounded-circle" src="img/undraw_profile.svg" style="width: 40px; height: 40px; object-fit: cover; flex-shrink: 0;">
                                        
                                        <!-- Teks nama dengan pengaturan agar tidak bertumpuk -->
                                        <p class="text-primary w-100 text-truncate" style="flex-shrink: 1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            <strong class="fw-bolder"><?=$username?></strong>
                                        </p>
                                    </div>
                                        <?php
                                            // Tampilkan dalam format dinamis
                                            if ($diff_seconds < 60) {
                                                echo "$diff_seconds detik yang lalu";
                                            } elseif ($diff_seconds < 3600) {
                                                $minutes = floor($diff_seconds / 60);
                                                echo "$minutes menit yang lalu";
                                            } elseif ($diff_seconds < 86400) {
                                                $hours = floor($diff_seconds / 3600);
                                                echo "$hours jam yang lalu";
                                            } else {
                                                $days = floor($diff_seconds / 86400);
                                                echo "$days hari yang lalu";
                                            }
                                        ?>
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center">
                                            <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 100%; height:40vh; object-fit:cover"
                                                src="<?=$tempImagePath?>" alt="...">
                                        </div>
                                        <div class = "row justify-content-around">
                                          <div class="col-md-3 ">

                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        Berat Badan</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$bb?> KG</div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class='bx bx-male bx-lg'></i>
                                                </div>
                                            </div>

                                          </div>
                                          <div class="col-md-3">
                                            <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                            Tinggi Badan</div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$tb?> CM</div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class='bx bx-ruler bx-lg'></i>
                                                    </div>
                                                </div>
                                          </div>
                                        </div>
                                        <hr>
                                        <p><strong>Catatan Kebugaran :</strong></p>
                                        <div class = "row border justify-content-center p-2" style="height:10vh ;overflow-y:scroll">
                                          <p class="text-center"><?=$catatan?></p>  
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                                <!--=======================-->
                            <?php
                            }}else{
                                ?>
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Informasi</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center">
                                            <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;"
                                                src="img/undraw_posting_photo.svg" alt="...">
                                        </div>
                                        <p class="text-center">Tampaknya belum ada yang berbagi progress saat, ini !</p> 
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                    

                        </div>

                        <!-- ================================================   Illustrations kanan   ================================================-->
                        <div class="col-lg-4 mb-4 p-3">
                            <!-- Illustrations kanan-->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Illustrations Kanan</h6>
                                </div>
                                <div class="card-body">
                                    <div class="text-center">
                                        <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;"
                                            src="img/undraw_posting_photo.svg" alt="...">
                                    </div>
                                    <p>Add some quality, svg illustrations to your project courtesy of <a
                                            target="_blank" rel="nofollow" href="https://undraw.co/">unDraw</a>, a
                                        constantly updated collection of beautiful svg images that you can use
                                        completely free and without attribution!</p>
                                    <a target="_blank" rel="nofollow" href="https://undraw.co/">Browse Illustrations on
                                        unDraw &rarr;</a>
                                </div>
                            </div>

                        </div>
                    </div>

                    
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