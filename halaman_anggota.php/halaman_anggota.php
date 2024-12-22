<?php
include '../inc/koneksi.php'; // Koneksi ke database
session_start();

// Periksa apakah anggota sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Tangkap data pengguna
$user_id = $_SESSION['user_id'];

// Proses Checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mobil_id = $_POST['mobil_id'];
    $jumlah = $_POST['jumlah'];

    // Validasi input
    if ($jumlah <= 0) {
        echo "<script>alert('Jumlah harus lebih dari 0'); window.location='checkout.php';</script>";
        exit();
    }

    // Ambil data mobil dari database
    $query = "SELECT * FROM mobil WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $mobil_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $mobil = $result->fetch_assoc();

    if (!$mobil) {
        echo "<script>alert('Mobil tidak ditemukan'); window.location='checkout.php';</script>";
        exit();
    }

    // Periksa stok
    if ($mobil['stok'] < $jumlah) {
        echo "<script>alert('Stok tidak mencukupi'); window.location='checkout.php';</script>";
        exit();
    }

    // Hitung total harga
    $total_harga = $mobil['harga'] * $jumlah;

    // Kurangi stok mobil
    $update_stok = "UPDATE mobil SET stok = stok - ? WHERE id = ?";
    $stmt = $conn->prepare($update_stok);
    $stmt->bind_param('ii', $jumlah, $mobil_id);
    $stmt->execute();

    // Simpan transaksi
    $insert_transaksi = "INSERT INTO transaksi (user_id, mobil_id, jumlah, total_harga) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_transaksi);
    $stmt->bind_param('iiii', $user_id, $mobil_id, $jumlah, $total_harga);
    $stmt->execute();

    echo "<script>alert('Checkout berhasil!'); window.location='checkout.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Mobil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

<!-- Header -->
<?php include 'header.php'; ?>

<div class="container mx-auto p-6">
    <h1 class="text-4xl font-bold text-gray-800 mb-6">Checkout Mobil</h1>

    <!-- Daftar Mobil -->
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
                $query = "SELECT * FROM mobil WHERE stok > 0";
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
                            <!-- Form Checkout -->
                            <form action="checkout.php" method="POST" class="inline-block">
                                <input type="hidden" name="mobil_id" value="<?php echo $row['id']; ?>">
                                <input type="number" name="jumlah" min="1" max="<?php echo $row['stok']; ?>" class="w-20 border rounded text-center">
                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500">Checkout</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center py-6 text-gray-500 italic">Tidak ada mobil yang tersedia.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
