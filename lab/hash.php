<?php

session_start();
    if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['pt1'])){
        header('location:../lab.php?pesan='. hash('sha256', $_POST['pt1']));
    }else{
        header('location:../lab.php?pesan=kosong');
    }

?>