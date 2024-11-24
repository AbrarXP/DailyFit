<?php
    session_start();

    include '../koneksi/cn.php';

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_POST['user']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password2'])){

            // Ngecek apakah ada field yang kosong
            if (empty($_POST['user']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['password2'])) {
                header('Location: register.php?pesan=kosong');
                exit();
            }
            
            // Antisipasi SQL Injection
            $user = mysqli_real_escape_string($cn, $_POST['user']);
            $email = mysqli_real_escape_string($cn, $_POST['email']);

            $pass = mysqli_real_escape_string($cn, $_POST['password']);
            $pass2 = mysqli_real_escape_string($cn, $_POST['password2']);

            // Mengecek apakah password sama atau tidak
            if($pass != $pass2){
                header('location:register.php?pesan=unmatched');
                exit();
            }

            
             // Check apakah ada akun yg terdaftar dgn username yg sama
             $query = mysqli_query($cn,"select * from users where username = '$user'");
             $cek = mysqli_num_rows($query);
 
             if($cek > 0){
                 header("location: register.php?pesan=terdaftar");
             }else{

                $pass = hash('sha256', $pass);

                $query = mysqli_query($cn,"insert into users values ('','$user','$email','$pass')");
                if($query){

                    $data = mysqli_query($cn,"select * from users where username = '$user'");
                    $userData = mysqli_fetch_array($data);

                    $_SESSION['userID'] =  $userData['id'];
                    $_SESSION['name'] = $userData['username'];
                    
                    header("location:../index.php?pesan=register");
                }
             }


            

        }
    }


?>