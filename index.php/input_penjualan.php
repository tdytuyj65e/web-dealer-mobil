<?php
include '../inc/koneksi.php'; // Koneksi database
include '../fpdf184/fpdf.php'; // Library FPDF

// Proses penyimpanan data penjualan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mobil_id = $_POST['mobil_id'];
    $nama_pembeli = $_POST['nama_pembeli'];
    $alamat = $_POST['alamat'];
    $jumlah = intval($_POST['jumlah']);

    // Ambil harga dan stok mobil dari database
    $query_harga = "SELECT harga, stok FROM mobil WHERE id = '$mobil_id'";
    $result_harga = mysqli_query($conn, $query_harga);
    $mobil = mysqli_fetch_assoc($result_harga);

    if (!$mobil || $mobil['stok'] < $jumlah) {
        $error_message = "Stok mobil tidak mencukupi! Hanya tersedia: " . ($mobil['stok'] ?? '0');
    } else {
        $harga_mobil = $mobil['harga'];
        $total_harga = $harga_mobil * $jumlah;

        // Simpan data ke tabel penjualan
        $insert_query = "INSERT INTO penjualan (mobil_id, nama_pembeli, alamat, jumlah, total_harga, tanggal) 
                         VALUES ('$mobil_id', '$nama_pembeli', '$alamat', '$jumlah', '$total_harga', NOW())";
        if (mysqli_query($conn, $insert_query)) {
            $penjualan_id = mysqli_insert_id($conn);

            // Kurangi stok mobil
            $update_stok = "UPDATE mobil SET stok = stok - $jumlah WHERE id = '$mobil_id'";
            mysqli_query($conn, $update_stok);

            // Buat PDF Kwitansi
            header('Content-Type: application/pdf');
            buat_pdf_kwitansi($penjualan_id, $conn);
            exit;
        } else {
            $error_message = "Gagal menyimpan data penjualan. Silakan coba lagi.";
        }
    }
}

// Fungsi untuk membuat PDF kwitansi
function buat_pdf_kwitansi($penjualan_id, $conn) {
    $query = "SELECT p.id, m.nama AS mobil, p.nama_pembeli, p.alamat, p.jumlah, p.total_harga, p.tanggal
              FROM penjualan p
              JOIN mobil m ON p.mobil_id = m.id
              WHERE p.id = '$penjualan_id'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);

    if (!$data) {
        die('Data penjualan tidak ditemukan.');
    }

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);

    // Header
    $pdf->Cell(0, 10, 'Kwitansi Pembelian Mobil', 0, 1, 'C');
    $pdf->Ln(10);

    // Detail Kwitansi
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(50, 10, 'ID Penjualan:', 0, 0);
    $pdf->Cell(0, 10, $data['id'], 0, 1);

    $pdf->Cell(50, 10, 'Nama Pembeli:', 0, 0);
    $pdf->Cell(0, 10, $data['nama_pembeli'], 0, 1);

    $pdf->Cell(50, 10, 'Alamat:', 0, 0);
    $pdf->MultiCell(0, 10, $data['alamat']);

    $pdf->Cell(50, 10, 'Mobil:', 0, 0);
    $pdf->Cell(0, 10, $data['mobil'], 0, 1);

    $pdf->Cell(50, 10, 'Jumlah:', 0, 0);
    $pdf->Cell(0, 10, $data['jumlah'], 0, 1);

    $pdf->Cell(50, 10, 'Total Harga:', 0, 0);
    $pdf->Cell(0, 10, 'Rp' . number_format($data['total_harga'], 0, ',', '.'), 0, 1);

    $pdf->Cell(50, 10, 'Tanggal:', 0, 0);
    $pdf->Cell(0, 10, date('d-m-Y H:i:s', strtotime($data['tanggal'])), 0, 1);

    // Footer
    $pdf->Ln(20);
    $pdf->Cell(0, 10, 'Terima kasih telah berbelanja.', 0, 1, 'C');

    $pdf->Output('I', 'Kwitansi_Penjualan_' . $data['id'] . '.pdf');
}

// Query untuk menampilkan data mobil
$query_mobil = "SELECT * FROM mobil";
$result_mobil = mysqli_query($conn, $query_mobil);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Penjualan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen font-sans">
    <div class="container mx-auto p-6">
        <h1 class="text-4xl font-bold text-gray-800 mb-6">Input Data Penjualan</h1>
        <a href="index.php" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500 mb-4 inline-block">Kembali ke Beranda</a>

        <div class="bg-white p-6 rounded-lg shadow-lg">
            <?php if (isset($error_message)): ?>
                <div class="bg-red-100 text-red-700 border border-red-300 p-4 rounded mb-4">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-4">
                <div>
                    <label for="mobil_id" class="block text-gray-700">Pilih Mobil</label>
                    <select name="mobil_id" id="mobil_id" class="w-full p-2 border border-gray-300 rounded" required>
                        <option value="">-- Pilih Mobil --</option>
                        <?php while ($row = mysqli_fetch_assoc($result_mobil)): ?>
                            <option value="<?php echo $row['id']; ?>">
                                <?php echo htmlspecialchars($row['nama']) . " (Rp" . number_format($row['harga'], 0, ',', '.') . ")"; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div>
                    <label for="nama_pembeli" class="block text-gray-700">Nama Pembeli</label>
                    <input type="text" id="nama_pembeli" name="nama_pembeli" class="w-full p-2 border border-gray-300 rounded" required>
                </div>
                <div>
                    <label for="alamat" class="block text-gray-700">Alamat</label>
                    <textarea id="alamat" name="alamat" class="w-full p-2 border border-gray-300 rounded" rows="4" required></textarea>
                </div>
                <div>
                    <label for="jumlah" class="block text-gray-700">Jumlah</label>
                    <input type="number" id="jumlah" name="jumlah" class="w-full p-2 border border-gray-300 rounded" required>
                </div>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-500">Simpan</button>
            </form>
        </div>
    </div>
</body>
</html>