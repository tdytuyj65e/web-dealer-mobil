<?php
include '../inc/koneksi.php'; // Koneksi database

// Query untuk menampilkan data penjualan
$query_penjualan = "SELECT p.id, m.nama AS mobil, p.nama_pembeli, p.alamat, p.jumlah, p.total_harga, p.tanggal
                    FROM penjualan p
                    JOIN mobil m ON p.mobil_id = m.id
                    ORDER BY p.tanggal DESC";
$result_penjualan = mysqli_query($conn, $query_penjualan);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Data Penjualan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* CSS untuk menyembunyikan elemen saat halaman dicetak */
        @media print {
            .no-print {
                display: none;
            }
            body {
                font-family: Arial, sans-serif;
            }
            .container {
                padding: 20px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }
            th, td {
                padding: 10px;
                text-align: left;
                border: 1px solid #ddd;
            }
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <div class="container mx-auto p-6">
        <h1 class="text-4xl font-bold text-gray-800 mb-6">Data Penjualan</h1>

        <!-- Tombol Cetak -->
        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500 mb-4 no-print" onclick="window.print()">Cetak Data Penjualan</button>

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

    <!-- Skrip untuk fungsi print -->
    <script>
        function printPage() {
            window.print();
        }
    </script>
</body>
</html>
