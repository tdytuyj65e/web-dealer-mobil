<?php
include '../inc/koneksi.php'; // Koneksi ke database
require('../fpdf184/fpdf.php'); // Sertakan FPDF untuk PDF generation

// Memeriksa apakah user mengklik link untuk download PDF
if (isset($_GET['download_pdf'])) {
    // Membuat instance FPDF
    $pdf = new FPDF();
    $pdf->AddPage();

    // Menambahkan judul
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(190, 10, 'Data Mobil', 0, 1, 'C');
    $pdf->Ln(10);

    // Menambahkan header tabel
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(10, 10, '#', 1);
    $pdf->Cell(40, 10, 'Gambar', 1);
    $pdf->Cell(40, 10, 'Nama Mobil', 1);
    $pdf->Cell(30, 10, 'Merek', 1);
    $pdf->Cell(40, 10, 'Harga', 1);
    $pdf->Cell(20, 10, 'Stok', 1);
    $pdf->Ln();

    // Menambahkan data dari database ke tabel PDF
    $pdf->SetFont('Arial', '', 12);
    $query = "SELECT * FROM mobil";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $pdf->Cell(10, 10, $row['id'], 1);
            $pdf->Cell(40, 10, !empty($row['gambar']) ? 'Ada' : 'Tidak Ada', 1);
            $pdf->Cell(40, 10, $row['nama'], 1);
            $pdf->Cell(30, 10, $row['merek'], 1);
            $pdf->Cell(40, 10, 'Rp ' . number_format($row['harga'], 0, ',', '.'), 1);
            $pdf->Cell(20, 10, $row['stok'], 1);
            $pdf->Ln();
        }
    }

    // Output PDF
    $pdf->Output('D', 'Data_Mobil.pdf');
    exit();
}

// Proses penghapusan data mobil
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Menghapus data mobil berdasarkan ID
    $query = "DELETE FROM mobil WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect ke halaman utama setelah berhasil menghapus
        header("Location: data_mobil.php?status=success");
        exit();
    } else {
        // Jika ada kesalahan
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mobil</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <script type="text/javascript">
        // Fungsi untuk membuka modal konfirmasi hapus
        function openModal(id) {
            const modal = document.getElementById('confirmModal');
            const confirmButton = document.getElementById('confirmDeleteBtn');
            // Menambahkan event listener untuk menghapus data
            confirmButton.onclick = function() {
                window.location.href = 'data_mobil.php?id=' + id; // Redirect ke halaman hapus
            }
            modal.classList.remove('hidden');
        }

        // Fungsi untuk menutup modal konfirmasi
        function closeModal() {
            const modal = document.getElementById('confirmModal');
            modal.classList.add('hidden');
        }
    </script>
</head>
<body class="bg-gray-100 font-sans">

<!-- Header (Navbar) -->
<?php include 'header.php'; ?>

<!-- Content -->
<div class="container mx-auto p-6">
    <h1 class="text-4xl font-bold text-gray-800 mb-6"></h1>

    <!-- Tombol Download PDF -->
    <a href="data_mobil.php?download_pdf=true" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-500 mb-4 inline-block">Download PDF</a>

    <!-- Notifikasi Penghapusan -->
    <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
        <div class="bg-green-600 text-white p-4 mb-4 rounded">Data mobil berhasil dihapus.</div>
    <?php endif; ?>

    <!-- Tabel Data Mobil -->
    <div class="overflow-x-auto bg-white shadow-lg rounded-lg mt-6">
        <table class="min-w-full table-auto text-left">
            <thead class="bg-green-700 text-white">
                <tr>
                    <th class="px-6 py-3">#</th>
                    <th class="px-6 py-3">Gambar</th>
                    <th class="px-6 py-3">Nama Mobil</th>
                    <th class="px-6 py-3">Merek</th>
                    <th class="px-6 py-3">Harga</th>
                    <th class="px-6 py-3">Stok</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM mobil";
                $result = $conn->query($query);
                if ($result->num_rows > 0):
                    while ($row = $result->fetch_assoc()):
                ?>
                    <tr class="bg-gray-50 hover:bg-gray-100 border-b">
                        <td class="px-6 py-4"><?php echo htmlspecialchars($row['id']); ?></td>
                        <td class="px-6 py-4">
                            <?php if (!empty($row['gambar'])): ?>
                                <img src="../assets/images/<?php echo htmlspecialchars($row['gambar']); ?>" alt="Gambar Mobil" class="h-16 w-auto rounded border border-gray-300">
                            <?php else: ?>
                                <span class="text-gray-500 italic">Tidak ada gambar</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4"><?php echo htmlspecialchars($row['nama']); ?></td>
                        <td class="px-6 py-4"><?php echo htmlspecialchars($row['merek']); ?></td>
                        <td class="px-6 py-4">Rp<?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                        <td class="px-6 py-4"><?php echo htmlspecialchars($row['stok']); ?></td>
                        <td class="px-6 py-4 text-center">
                            <a href="edit_mobil.php?id=<?php echo $row['id']; ?>" class="text-blue-600 hover:underline">Edit</a>
                            <span class="text-gray-400 mx-2">|</span>
                            <!-- Tombol hapus dengan modal konfirmasi -->
                            <button class="text-red-600 hover:underline" onclick="openModal(<?php echo $row['id']; ?>)">Hapus</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center py-6 text-gray-500 italic">Tidak ada data mobil.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div id="confirmModal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white p-6 rounded-lg w-1/3">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Konfirmasi Hapus</h2>
        <p class="text-gray-700 mb-4">Apakah Anda yakin ingin menghapus mobil ini?</p>
        <div class="flex justify-end space-x-4">
            <button onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Tidak</button>
            <button id="confirmDeleteBtn" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Ya, Hapus</button>
        </div>
    </div>
</div>

</body>
</html>
