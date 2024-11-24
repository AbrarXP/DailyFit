<?php


    $cn = new mysqli("localhost","root","","kriptografi");

    if ($cn->connect_error) {
        die("Koneksi Gagal: " . $cn->connect_error);
    }

?>