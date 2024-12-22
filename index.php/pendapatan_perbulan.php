<?php
include '../inc/koneksi.php'; // Koneksi database
include 'header.php'; // Header

// Query untuk menampilkan pendapatan berdasarkan total harga per bulan
$query_pendapatan = "SELECT
                        YEAR(tanggal) AS tahun,
                        MONTH(tanggal) AS bulan,
                        SUM(total_harga) AS total_pendapatan
                    FROM penjualan
                    GROUP BY YEAR(tanggal), MONTH(tanggal)
                    ORDER BY tahun DESC, bulan DESC";

$result_pendapatan = mysqli_query($conn, $query_pendapatan);
?>

<!DOCTYPE html>
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

        <!-- Tabel Pendapatan -->
        <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
            <table class="min-w-full table-auto text-left">
                <thead class="bg-blue-700 text-white">
                    <tr>
                        <th class="px-6 py-3">#</th>
                        <th class="px-6 py-3">Tahun</th>
                        <th class="px-6 py-3">Bulan</th>
                        <th class="px-6 py-3">Pendapatan (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result_pendapatan) > 0): ?>
                        <?php $counter = 1; ?>
                        <?php while ($row = mysqli_fetch_assoc($result_pendapatan)): ?>
                            <tr class="bg-gray-50 hover:bg-gray-100 border-b">
                                <td class="px-6 py-4"><?php echo $counter++; ?></td>
                                <td class="px-6 py-4"><?php echo $row['tahun']; ?></td>
                                <td class="px-6 py-4"><?php echo bulanTerbilang($row['bulan']); ?></td>
                                <td class="px-6 py-4">Rp<?php echo number_format($row['total_pendapatan'], 0, ',', '.'); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-6 text-gray-500">Tidak ada data pendapatan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php
// Fungsi untuk mengubah angka bulan menjadi nama bulan
function bulanTerbilang($bulan) {
    $bulan_arr = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
        7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];
    return $bulan_arr[$bulan];
}
?>
