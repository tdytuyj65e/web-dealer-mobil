<?php
include '../inc/koneksi.php'; // Koneksi database
require('../fpdf184/fpdf.php'); // Memasukkan library FPDF

// Mendapatkan aksi untuk download PDF
$download_pdf = isset($_GET['download_pdf']) ? true : false;

// Jika diminta untuk download PDF, buat PDF untuk seluruh tabel
if ($download_pdf) {
    // Query untuk mengambil seluruh data penjualan
    $query_penjualan = "SELECT p.id, m.nama AS mobil, p.nama_pembeli, p.alamat, p.jumlah, p.total_harga, p.tanggal
                        FROM penjualan p
                        JOIN mobil m ON p.mobil_id = m.id
                        ORDER BY p.tanggal DESC";
    $result_penjualan = mysqli_query($conn, $query_penjualan);

    // Membuat instance FPDF
    $pdf = new FPDF('P', 'mm', 'A4');
    $pdf->AddPage();

    // Judul PDF
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(190, 10, 'Data Penjualan Mobil', 0, 1, 'C');
    $pdf->Ln(10);

    // Header Tabel
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(10, 10, 'No', 1);
    $pdf->Cell(40, 10, 'Mobil', 1);
    $pdf->Cell(40, 10, 'Nama Pembeli', 1);
    $pdf->Cell(40, 10, 'Alamat', 1);
    $pdf->Cell(20, 10, 'Jumlah', 1);
    $pdf->Cell(30, 10, 'Total Harga', 1);
    $pdf->Cell(30, 10, 'Tanggal', 1);
    $pdf->Ln();

    // Data Tabel
    $pdf->SetFont('Arial', '', 12);
    $no = 1;
    while ($row = mysqli_fetch_assoc($result_penjualan)) {
        $pdf->Cell(10, 10, $no++, 1);
        $pdf->Cell(40, 10, $row['mobil'], 1);
        $pdf->Cell(40, 10, $row['nama_pembeli'], 1);
        $pdf->Cell(40, 10, $row['alamat'], 1);
        $pdf->Cell(20, 10, $row['jumlah'], 1);
        $pdf->Cell(30, 10, 'Rp ' . number_format($row['total_harga'], 0, ',', '.'), 1);
        $pdf->Cell(30, 10, date('d-m-Y', strtotime($row['tanggal'])), 1);
        $pdf->Ln();
    }

    // Output PDF
    $pdf->Output('D', 'Data_Penjualan_Mobil.pdf');
    exit();
}

// Query untuk menampilkan data penjualan di tabel
$query_penjualan = "SELECT p.id, m.nama AS mobil, p.nama_pembeli, p.alamat, p.jumlah, p.total_harga, p.tanggal
                    FROM penjualan p
                    JOIN mobil m ON p.mobil_id = m.id
                    ORDER BY p.tanggal DESC";
$result_penjualan = mysqli_query($conn, $query_penjualan);
?>

<!DOCTYPE html>
<?php include 'header.php'; ?>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen font-sans">
    <div class="container mx-auto p-6">
        <h1 class="text-4xl font-bold text-gray-800 mb-6"></h1>
        <a href="input_penjualan.php" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500 mb-4 inline-block">Tambah Penjualan</a>
        
        <!-- Tombol untuk Download PDF Seluruh Tabel -->
        <a href="index.php?download_pdf=true" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-500 mb-4 inline-block">Download PDF Tabel Penjualan</a>

        <!-- Tabel Data Penjualan -->
        <?php if (mysqli_num_rows($result_penjualan) > 0): ?>
            <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
       
                <thead class="bg-gray-100">

                    <tr>
                        <th class="py-2 px-4 border">No</th>
                        <th class="py-2 px-4 border">Mobil</th>
                        <th class="py-2 px-4 border">Nama Pembeli</th>
                        <th class="py-2 px-4 border">Alamat</th>
                        <th class="py-2 px-4 border">Jumlah</th>
                        <th class="py-2 px-4 border">Total Harga</th>
                        <th class="py-2 px-4 border">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result_penjualan)):
                    ?>
                        <tr>
                            <td class="py-2 px-4 border"><?php echo $no++; ?></td>
                            <td class="py-2 px-4 border"><?php echo htmlspecialchars($row['mobil']); ?></td>
                            <td class="py-2 px-4 border"><?php echo htmlspecialchars($row['nama_pembeli']); ?></td>
                            <td class="py-2 px-4 border"><?php echo htmlspecialchars($row['alamat']); ?></td>
                            <td class="py-2 px-4 border"><?php echo htmlspecialchars($row['jumlah']); ?></td>
                            <td class="py-2 px-4 border">Rp<?php echo number_format($row['total_harga'], 0, ',', '.'); ?></td>
                            <td class="py-2 px-4 border"><?php echo date('d-m-Y H:i:s', strtotime($row['tanggal'])); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-red-500">Tidak ada data penjualan.</p>
        <?php endif; ?>
    </div>
</body>
</html>
