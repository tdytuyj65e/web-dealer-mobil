<?php
// Koneksi ke database
include '../inc/koneksi.php';

// Memuat library FPDF untuk membuat PDF
require('../fpdf184/fpdf.php');

// Memproses form ketika data dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_telepon = $_POST['no_telepon'];
    $email = $_POST['email'];
    $status = $_POST['status'];

    // Mengunggah file gambar
    $foto = $_FILES['foto'];
    $foto_nama = time() . "_" . basename($foto['name']);
    $foto_path = __DIR__ . "/uploads/" . $foto_nama;

    // Periksa apakah folder uploads ada, jika tidak buat folder
    if (!is_dir(__DIR__ . '/uploads')) {
        mkdir(__DIR__ . '/uploads', 0777, true);
    }

    if (move_uploaded_file($foto['tmp_name'], $foto_path)) {
        // Simpan data ke database
        $query = "INSERT INTO anggota (nama, alamat, no_telepon, email, foto, status)
                  VALUES ('$nama', '$alamat', '$no_telepon', '$email', '$foto_nama', '$status')";

        if ($conn->query($query)) {
            $id_anggota = $conn->insert_id;

            // Membuat instance objek FPDF
            $pdf = new FPDF();
            $pdf->AddPage();

            // Warna background dan border
            $pdf->SetFillColor(240, 240, 240); // Abu-abu terang
            $pdf->SetDrawColor(50, 50, 100);  // Warna border biru tua

            // Header kartu
            $pdf->SetFont('Arial', 'B', 18);
            $pdf->SetTextColor(255, 255, 255); // Warna teks putih
            $pdf->SetFillColor(0, 128, 255);   // Warna background header biru
            $pdf->Cell(190, 20, 'Kartu Anggota', 0, 1, 'C', true);

            // Tambahkan border luar
            $pdf->Rect(10, 30, 190, 130); // X, Y, Lebar, Tinggi

            // Foto Anggota
            $pdf->Image(__DIR__ . '/uploads/' . $foto_nama, 15, 45, 40, 50); // X, Y, Lebar, Tinggi

            // Garis pemisah
            $pdf->Line(60, 45, 60, 125); // Garis vertikal

            // Informasi Anggota
            $pdf->SetFont('Arial', '', 12);
            $pdf->SetTextColor(0, 0, 0); // Warna teks hitam

            $pdf->SetXY(70, 50); // Atur posisi teks
            $pdf->Cell(0, 10, 'Nama          : ' . $nama, 0, 1);
            $pdf->SetX(70);
            $pdf->Cell(0, 10, 'Alamat       : ' . $alamat, 0, 1);
            $pdf->SetX(70);
            $pdf->Cell(0, 10, 'No Telepon : ' . $no_telepon, 0, 1);
            $pdf->SetX(70);
            $pdf->Cell(0, 10, 'Email          : ' . $email, 0, 1);
            $pdf->SetX(70);
            $pdf->Cell(0, 10, 'Status        : ' . $status, 0, 1);

            // Footer kartu
            $pdf->SetY(160);
            $pdf->SetFont('Arial', 'I', 10);
            $pdf->SetTextColor(100, 100, 100); // Warna abu-abu
            $pdf->Cell(0, 10, 'Diterbitkan pada ' . date('d-m-Y'), 0, 1, 'C');

            // Mengunduh PDF
            $pdf_name = "Kartu_Anggota_" . $id_anggota . ".pdf";
            $pdf->Output('D', $pdf_name);
            exit;
        } else {
            echo "<script>alert('Gagal menambahkan anggota ke database!');</script>";
        }
    } else {
        echo "<script>alert('Gagal mengunggah foto! Periksa izin folder.');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Anggota</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans min-h-screen">
    <div class="container mx-auto p-6">
        <h1 class="text-4xl font-bold mb-6 text-gray-800">Tambah Anggota</h1>

        <!-- Form Tambah Anggota -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="nama" class="block text-gray-700 font-bold">Nama:</label>
                    <input type="text" name="nama" id="nama" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required>
                </div>
                <div class="mb-4">
                    <label for="alamat" class="block text-gray-700 font-bold">Alamat:</label>
                    <textarea name="alamat" id="alamat" rows="3" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required></textarea>
                </div>
                <div class="mb-4">
                    <label for="no_telepon" class="block text-gray-700 font-bold">No. Telepon:</label>
                    <input type="text" name="no_telepon" id="no_telepon" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-bold">Email:</label>
                    <input type="email" name="email" id="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                <div class="mb-4">
                    <label for="foto" class="block text-gray-700 font-bold">Foto:</label>
                    <input type="file" name="foto" id="foto" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" accept="image/*" required>
                </div>
                <div class="mb-4">
                    <label for="status" class="block text-gray-700 font-bold">Status:</label>
                    <select name="status" id="status" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="Aktif">Aktif</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                    </select>
                </div>
                <button class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600"><a href="anggota.php">Kembali</a></button>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">Tambah Anggota</button>
            </form>
        </div>
    </div>
</body>
</html>
