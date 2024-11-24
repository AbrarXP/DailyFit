<?php

session_start();

function caesarCipher($text, $shift) {
    $result = '';

    foreach (str_split($text) as $char) {
        $result .= chr((ord($char) + $shift) % 256);
    }

    return $result;
}

function rc4($key, $data) {
    $s = range(0, 255);
    $j = 0;

    // Key-scheduling algorithm (KSA)

    /*Looping ini bertujuan mengacak variabel array S berdasarkan kunci yang diberikan */
    for ($i = 0; $i < 256; $i++) {
        $j = ($j + $s[$i] + ord($key[$i % strlen($key)])) % 256;
        list($s[$i], $s[$j]) = [$s[$j], $s[$i]]; 

    }

    // Pseudo-random generation algorithm (PRGA)
    $i = $j = 0;
    $result = '';
    for ($k = 0; $k < strlen($data); $k++) {
        $i = ($i + 1) % 256;
        $j = ($j + $s[$i]) % 256;
        list($s[$i], $s[$j]) = [$s[$j], $s[$i]];
        $result .= chr(ord($data[$k]) ^ $s[($s[$i] + $s[$j]) % 256]);
    }

    return $result;
}




    if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['pt1']) && !empty($_POST['key']) && !empty($_POST['key2'])){

        $pt = $_POST['pt1'];

        $pt = caesarCipher($pt, $_POST['key']);
        $pt2 = rc4($_POST['key2'], $pt);
        
        $_SESSION['pt'] = $pt;
        $_SESSION['pt2'] = $pt2;

        
        header('location:../lab.php');
    }else{
        header('location:../lab.php?pesan=kosong');
    }

?>