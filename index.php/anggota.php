<?php
// Koneksi ke database
include '../inc/koneksi.php'; 
?>

<!DOCTYPE html>
<?php
include 'header.php';
?>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Anggota</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans min-h-screen">
    <div class="container mx-auto p-6">
        <h1 class="text-4xl font-bold mb-6 text-gray-800"></h1>

        <!-- Tabel Anggota -->
        <div class="flex justify-between items-center mb-4">
    <!-- Tombol Tambah Anggota -->
    <a href="input_anggota.php" 
       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500 transition">
       Tambah Anggota
    </a>
</div>

<!-- Tabel Data Anggota -->

<div class="overflow-x-auto bg-white shadow-lg rounded-lg">
    <!-- Isi tabel Anda di sini -->
</div>

        <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
            <table class="min-w-full table-auto text-left">
                <thead class="bg-blue-700 text-white">
                    <tr>
                        <th class="px-6 py-3">#</th>
                        <th class="px-6 py-3">Foto</th>
                        <th class="px-6 py-3">Nama</th>
                        <th class="px-6 py-3">Alamat</th>
                        <th class="px-6 py-3">No. Telepon</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Query untuk mengambil data anggota
                    $query = "SELECT * FROM anggota";
                    $result = $conn->query($query);

                    if ($result->num_rows > 0):
                        $counter = 1;
                        while ($row = $result->fetch_assoc()):
                    ?>
                    <tr class="bg-gray-50 hover:bg-gray-100 border-b">
                        <td class="px-6 py-4"><?php echo $counter++; ?></td>
                        <td class="px-6 py-4">
                            <img src="uploads/<?php echo $row['foto']; ?>" alt="Foto Anggota" class="h-16 w-16 object-cover rounded-full">
                        </td>
                        <td class="px-6 py-4"><?php echo htmlspecialchars($row['nama']); ?></td>
                        <td class="px-6 py-4"><?php echo htmlspecialchars($row['alamat']); ?></td>
                        <td class="px-6 py-4"><?php echo htmlspecialchars($row['no_telepon']); ?></td>
                        <td class="px-6 py-4"><?php echo htmlspecialchars($row['email']); ?></td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-white <?php echo $row['status'] === 'Aktif' ? 'bg-green-500' : 'bg-red-500'; ?>">
                                <?php echo htmlspecialchars($row['status']); ?>
                            </span>
                        </td>
                    </tr>
                    <?php endwhile; else: ?>
                    <tr>
                        <td colspan="7" class="text-center py-6 text-gray-500">Tidak ada anggota yang ditemukan.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
