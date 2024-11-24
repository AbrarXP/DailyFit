<?php
function encodeLSB($imagePath, $message) {
    // Membaca gambar (PNG)
    $image = imagecreatefrompng($imagePath); 
    if (!$image) {
        die("Gagal memuat gambar.");
    }

    // Menambahkan karakter null untuk menandai akhir pesan
    $message .= chr(0); 
    $messageBinary = encodeBiner($message);  // Mengonversi pesan ke biner
    
    $messageIndex = 0;
    $width = imagesx($image);  // Lebar gambar
    $height = imagesy($image); // Tinggi gambar

    $panjangMessageBinary = strlen($messageBinary);

    $maxCapacity = $width * $height * 3; // Kapasitas maksimum bit
    if (strlen($messageBinary) > $maxCapacity) {
        die("Pesan terlalu panjang untuk disisipkan ke dalam gambar ini.");
    }

    // Looping untuk setiap pixel gambar
    for ($x = 0; $x < $width; $x++) {
        for ($y = 0; $y < $height; $y++) {
            $rgb = imagecolorat($image, $x, $y); // Mendapatkan warna RGB pixel
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;

            /*
            Cara kerja penyisipan
            1. ($r & 0xFE) <- Membersihkan LSB supaya menjadi 0  (dikurang 1 bit dengan bitwise and)
            contoh :
              10011101   (r: 157, sebelum diubah)
            & 11111110   (Mask: 0xFE)
            ------------
              10011100   (Hasil: 156)


            2. ($r & 0xFE) | (int)$messageBinary[$messageIndex++]; <- kemudian memasukan array yang berisi binary sesuai dengan index dengan operator or |
               contoh :
              10011100   (r: 156, setelah di bersihkan dengan and)
            | 00000001  (Bit pesan yg akan disisipkan: 1)
            ------------
              10011100   (Hasil: 157)
            */

            if($messageIndex < $panjangMessageBinary) {
                // Menyisipkan bit pesan ke dalam LSB dari RGB
                $r = ($r & 0xFE) | (int)$messageBinary[$messageIndex++];
            }
            if($messageIndex < $panjangMessageBinary) {
                $g = ($g & 0xFE) | (int)$messageBinary[$messageIndex++];
            }
            if($messageIndex < $panjangMessageBinary) {
                $b = ($b & 0xFE) | (int)$messageBinary[$messageIndex++];  
            }

            // Menyimpan pixel dengan warna yang sudah diubah
            $newColor = imagecolorallocate($image, $r, $g, $b);
            imagesetpixel($image, $x, $y, $newColor);
        }
    }
    echo "Panjang messageBinary: " . strlen($messageBinary) . "\n";
    echo "Index sekarang: " . $messageIndex . "\n";
    // Menyimpan gambar yang sudah diencode ke dalam file
    $encodedImagePath = 'encoded_image.png';
    imagepng($image, $encodedImagePath);  // Menyimpan gambar ke file
    imagedestroy($image);  // Menghapus gambar dari memori

    // Mengembalikan path gambar yang sudah diencode
    return $encodedImagePath;
}


// Fungsi untuk mengekstrak pesan dari gambar (Decode LSB)
function decodeLSB($imagePath) {
    // Membaca gambar
    $image = imagecreatefrompng($imagePath);
    $width = imagesx($image);
    $height = imagesy($image);
    $binaryMessage = "";

    // Looping setiap pixel gambar untuk ekstrak bit LSB
    for ($x = 0; $x < $width; $x++) {
        for ($y = 0; $y < $height; $y++) {
            $rgb = imagecolorat($image, $x, $y);
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;

            // Ekstrak 1 bit LSB dari setiap komponen warna
            $binaryMessage .= (string)($r & 1);
            $binaryMessage .= (string)($g & 1);
            $binaryMessage .= (string)($b & 1);
        }
    }

    // Mengonversi biner kembali menjadi pesan (ASCII)
    $message = "";
    for ($i = 0; $i < strlen($binaryMessage); $i += 8) {
        // Ambil 8 bit untuk setiap karakter
        $charBinary = substr($binaryMessage, $i, 8);

        // Jika kurang dari 8 bit, hentikan loop
        if (strlen($charBinary) < 8) {
            break;
        }

        // Konversi biner ke karakter ASCII
        $char = chr(bindec($charBinary));

        // Jika menemukan karakter null (\0), hentikan decoding
        if ($char === "\0") {
            break;
        }

        $message .= $char;
    }

    imagedestroy($image);
    return $message;
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

function caesarCipher($text, $shift) {
    $result = '';

    foreach (str_split($text) as $char) {
        $result .= chr((ord($char) + $shift) % 256);
    }

    return $result;
}

function encodeBiner($message){

    // Encode pesan ke dalam biner

    $messageBinary = "";
    for ($i = 0; $i < strlen($message); $i++) {
        $messageBinary .= sprintf("%08b", ord($message[$i]));
    }

    return $messageBinary;
}

function decodeBiner($binaryData) {
    $string = '';
    // Memecah data biner menjadi 8-bit (1 byte) per karakter
    for ($i = 0; $i < strlen($binaryData); $i += 8) {
        // Ambil 8 bit untuk setiap karakter
        $byte = substr($binaryData, $i, 8);
        // Mengonversi byte biner menjadi karakter dan menambahkannya ke string
        $string .= chr(bindec($byte));  // bindec() mengonversi biner ke desimal
    }

    return $string;
}



if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        session_start();
        include 'koneksi/cn.php';

        $key = 3;
        $key2 = "selamaSingaBelumBisaMenulisSemuaCeritaAkanMengagungkanSangPemburu";

        // Sekedar menyimpan image path: C:\Program Files\xampp2\tmp\php275E.tmp
        $imagePath = $_FILES['gambar']['tmp_name'];
        $catatan = $_POST['catatan'];
        $tb = $_POST['tb'];
        $bb = $_POST['bb'];
        $user = $_SESSION['userID'];

        // Proses superenkripsi
        $catatan = mysqli_escape_string($cn,$catatan);
        $catatan = caesarCipher($catatan, $key);
        $catatan = rc4($key2, $catatan);

        $tb = mysqli_escape_string($cn,$tb);
        $tb = caesarCipher($tb, $key);
        $tb = rc4($key2, $tb);
        
        $bb = mysqli_escape_string($cn,$bb);
        $bb = caesarCipher($bb, $key);
        $bb = rc4($key2, $bb);
        
        // mengencode pesan pada imagePath, encodedImagePath isinya path
        $encodedImagePath = encodeLSB($imagePath, $catatan);

        // Membaca isi gambar dan disimpan dalam bentuk biner pada $binerImage
        $binerImage = file_get_contents($encodedImagePath);
        

        // Mengubah hasil enkripsi menjadi base64 agar database menyimpan data secara konsisten
        $baseImage = base64_encode($binerImage);
        $baseTB = base64_encode($tb);
        $baseBB = base64_encode($bb);


        //echo '<img src="data:image/jpeg;base64,' . $baseImage . '" alt="Uploaded Image">';
        echo '<img src="' . $encodedImagePath . '" alt="Encoded Image">';

        //$rc4 = rc4($key2, $bb);
        //$caesar = caesarCipher($rc4, -$key);


        // Cara menampilkan pesan dari database
        $binerImage = base64_decode($baseImage);// decode base64 jadi biner
        
        $tempImagePath = 'temp_encoded_image.png'; // Nama sementara untuk file
        file_put_contents($tempImagePath, $binerImage);// Menyimpan data biner ke file
        $catatan = decodeLSB($tempImagePath);

        $catatan = rc4($key2, $catatan);
        $catatan = caesarCipher($catatan, -$key);
        
         
        echo '<br>' .$catatan;

        
        $query = mysqli_query($cn,"insert into progress values ('','$user',DEFAULT,'$baseTB','$baseBB','$baseImage')");
        if($query){
            header('location:index.php?pesan=berhasil');
        }else{
            echo "Error: " . mysqli_error($cn);
            echo "<br>";
            echo "Query: insert into progress values ('','$user',DEFAULT,'$baseTB','$baseBB','$baseImage')";

        }
        
        //echo bin2hex($binerImage);

        // di encode ke base64 agar bisa di tampilkan
        //$base64Image = base64_encode($fileData); // Encode ke Base64
        
        //echo '<img src="data:image/jpeg;base64,' . $base64img . '" alt="Uploaded Image">';

        
    } else {
        echo "Gambar tidak valid.";
    }
}
?>