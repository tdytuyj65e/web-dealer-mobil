<?php
// Informasi koneksi ke database
$host = "localhost";
$user = "root";
$password = "";
$database = "dealer_mobil";

// Mencoba membuat koneksi
$conn = mysqli_connect($host, $user, $password, $database);

// Mengecek apakah koneksi berhasil
if (!$conn) {
    // Menampilkan pesan kesalahan dan menghentikan eksekusi jika koneksi gagal
    die("Koneksi gagal: " . mysqli_connect_error());
} else {
    // Jika koneksi berhasil
    // Optional: Menampilkan pesan sukses atau log koneksi berhasil
    // echo "Koneksi ke database berhasil!";
}
?>
