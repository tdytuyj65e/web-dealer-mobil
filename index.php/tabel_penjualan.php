<?php
include '../inc/koneksi.php'; // Koneksi database

// Query untuk total penjualan dan mobil terjual
$query_summary = "SELECT SUM(total_harga) AS total_penjualan, COUNT(id) AS jumlah_penjualan 
                  FROM penjualan";
$result_summary = mysqli_query($conn, $query_summary);
$summary = mysqli_fetch_assoc($result_summary);

// Query untuk grafik penjualan bulanan
$query_graph = "SELECT MONTH(tanggal) AS bulan, SUM(total_harga) AS total_bulanan
                FROM penjualan
                GROUP BY MONTH(tanggal)
                ORDER BY bulan ASC";
$result_graph = mysqli_query($conn, $query_graph);

// Query untuk menampilkan data penjualan terbaru
$query_penjualan = "SELECT p.id, m.nama AS mobil, p.nama_pembeli, p.alamat, p.jumlah, p.total_harga, p.tanggal
                    FROM penjualan p
                    JOIN mobil m ON p.mobil_id = m.id
                    ORDER BY p.tanggal DESC LIMIT 5";
$result_penjualan = mysqli_query($conn, $query_penjualan);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dealer Mobil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">

<!-- Sidebar dan Konten -->
<?php
include 'header.php';
?>
    <!-- Main Content -->
    <div class="flex-1 p-6">
        <h1 class="text-4xl font-bold text-gray-800 mb-6"></h1>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-6">
            <div class="card">
                <h3 class="text-lg font-semibold text-gray-700">Total Penjualan</h3>
                <p class="text-2xl text-green-600">Rp <?php echo number_format($summary['total_penjualan'], 0, ',', '.'); ?></p>
            </div>
            <div class="card">
                <h3 class="text-lg font-semibold text-gray-700">Jumlah Penjualan</h3>
                <p class="text-2xl text-blue-600"><?php echo $summary['jumlah_penjualan']; ?> Transaksi</p>
            </div>
        </div>

        <!-- Chart Penjualan -->
        <div class="card mb-6">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Grafik Penjualan Bulanan</h3>
            <canvas id="penjualanChart"></canvas>
        </div>

    <script>
    // Grafik Penjualan Bulanan
    var ctx = document.getElementById('penjualanChart').getContext('2d');
    var penjualanChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [<?php 
                while ($row = mysqli_fetch_assoc($result_graph)) {
                    echo '"' . $row['bulan'] . '",';
                } ?>],
            datasets: [{
                label: 'Total Penjualan',
                data: [<?php 
                mysqli_data_seek($result_graph, 0); // Reset result set pointer
                while ($row = mysqli_fetch_assoc($result_graph)) {
                    echo $row['total_bulanan'] . ',';
                } ?>],
                borderColor: 'rgb(75, 192, 192)',
                fill: false
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Grafik Penjualan Bulanan'
                }
            }
        }
    });
</script>

</body>
</html>
