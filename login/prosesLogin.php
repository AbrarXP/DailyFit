<?php
    session_start();

    include '../koneksi/cn.php';

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_POST['user']) && isset($_POST['password'])){

            // Ngecek apakah ada field yang kosong
            if (empty($_POST['user']) || empty($_POST['password'])) {
                header('Location: login.php?pesan=kosong');
                exit();
            }
            
            $user = mysqli_real_escape_string($cn, $_POST['user']);
            $pass = mysqli_real_escape_string($cn, $_POST['password']);

            $pass = hash('sha256', $pass);
            
             $query = mysqli_query($cn,
             "select * from users where username = '$user' and password = '$pass'");

             
             $cek = mysqli_num_rows($query);
             if($cek == 0){
                 header("location: login.php?pesan=salah");
             }else{
                if($query){
                    $userData = mysqli_fetch_array($query);
                    $_SESSION['userID'] =  $userData['id'];
                    $_SESSION['name'] = $userData['username'];
                    header("location:../index.php?pesan=login");
                }
             }


            

        }
    }


?>