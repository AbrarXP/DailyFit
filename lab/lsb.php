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

function encodeBiner($message){

    // Encode pesan ke dalam biner
    $message .= chr(0);  // Menambahkan karakter null sebagai penanda akhir pesan
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

// Fungsi untuk mengekstrak pesan dari gambar (Decode LSB)


    session_start();
    if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['pt1']) && isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0){

        $pathImage = $_FILES['gambar']['tmp_name'];
        $pesan = $_POST['pt1'];

        $newImagePath = encodeLSB($pathImage, $pesan);

        $base64img = base64_encode(file_get_contents($pathImage));
        $base64imgLSB = base64_encode(file_get_contents($newImagePath));


        $binerImage = base64_decode($base64imgLSB);
        $tempImagePath = 'temporary_encoded_Image.png';
        file_put_contents($tempImagePath, $binerImage);
        $catatan = decodeLSB($tempImagePath);

        $_SESSION['gambarAwal'] = $base64img;
        $_SESSION['gambarAkhir'] = $base64imgLSB;
        $_SESSION['catatan'] = $catatan;

        header('Location: ../lab.php?pesan23=berhasil');

        
    }

?>