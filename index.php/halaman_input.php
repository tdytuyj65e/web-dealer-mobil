<?php
include '../inc/koneksi.php';
include 'header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $merek = mysqli_real_escape_string($conn, $_POST['merek']);
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $gambar = '';

    // Proses upload gambar
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $gambar_name = $_FILES['gambar']['name'];
        $gambar_tmp = $_FILES['gambar']['tmp_name'];
        
        // Tentukan folder tujuan
        $gambar_folder = '../assets/images/';
        
        // Pastikan folder ada
        if (!is_dir($gambar_folder)) {
            mkdir($gambar_folder, 0755, true);
        }
        
        // Generate nama unik untuk file
        $ext = pathinfo($gambar_name, PATHINFO_EXTENSION);
        $gambar = uniqid('img_', true) . '.' . $ext;
        $gambar_path = $gambar_folder . $gambar;
        
        // Validasi format file
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array(strtolower($ext), $allowed_ext)) {
            // Pindahkan file
            if (move_uploaded_file($gambar_tmp, $gambar_path)) {
                echo "Gambar berhasil diupload.";
            } else {
                echo "Gagal mengupload gambar.";
                $gambar = ''; // Kosongkan jika gagal
            }
        } else {
            echo "<script>alert('Hanya file dengan format JPG, JPEG, PNG, atau GIF yang diperbolehkan.');</script>";
            $gambar = ''; // Kosongkan jika format tidak valid
        }
    }

    // Query untuk memasukkan data ke dalam database
    $query = "INSERT INTO mobil (nama, merek, harga, stok, deskripsi, gambar) 
              VALUES ('$nama', '$merek', '$harga', '$stok', '$deskripsi', '$gambar')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Mobil berhasil ditambahkan!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan. Mobil gagal ditambahkan.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
    <div class="container mx-auto px-6 py-8">
        <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold text-gray-700 mb-6">Tambah Mobil Baru</h2>
            
            <!-- Form Input Mobil -->
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="nama" class="block text-gray-700">Nama Mobil</label>
                    <input type="text" id="nama" name="nama" class="w-full p-3 mt-2 border border-gray-300 rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="merek" class="block text-gray-700">Merek</label>
                    <input type="text" id="merek" name="merek" class="w-full p-3 mt-2 border border-gray-300 rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="harga" class="block text-gray-700">Harga (Rp)</label>
                    <input type="number" id="harga" name="harga" class="w-full p-3 mt-2 border border-gray-300 rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="stok" class="block text-gray-700">Stok</label>
                    <input type="number" id="stok" name="stok" class="w-full p-3 mt-2 border border-gray-300 rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="deskripsi" class="block text-gray-700">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="4" class="w-full p-3 mt-2 border border-gray-300 rounded-md" required></textarea>
                </div>

                <div class="mb-4">
                    <label for="gambar" class="block text-gray-700">Gambar Mobil</label>
                    <input type="file" id="gambar" name="gambar" class="w-full p-3 mt-2 border border-gray-300 rounded-md" accept="image/*" required>
                </div>

                <div class="mb-4 text-center">
                    <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-500">Tambah Mobil</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
