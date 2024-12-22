<?php
include '../inc/inc.php'; // Include konfigurasi database
include 'header.php'; // Include header yang sudah ada (jika ada)

// Cek apakah edit_id ada
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    
    // Ambil data mobil berdasarkan edit_id
    $query = "SELECT * FROM mobil WHERE id = '$edit_id'";
    $result = mysqli_query($conn, $query);
    $mobil = mysqli_fetch_assoc($result);

    if (!$mobil) {
        echo "Mobil tidak ditemukan.";
        exit;
    }

    // Proses pembaruan data mobil jika form disubmit
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Ambil data dari form
        $nama = $_POST['nama'];
        $merek = $_POST['merek'];
        $harga = $_POST['harga'];
        $stok = $_POST['stok'];
        $gambar = $_FILES['gambar']['name'];

        // Proses gambar jika ada yang diupload
        if ($gambar) {
            $gambar_temp = $_FILES['gambar']['tmp_name'];
            $gambar_path = '../assets/images/' . $gambar;
            move_uploaded_file($gambar_temp, $gambar_path);
        } else {
            $gambar = $mobil['gambar']; // Jika tidak ada gambar baru, gunakan gambar lama
        }

        // Update data mobil
        $update_query = "UPDATE mobil SET 
                            nama = '$nama', 
                            merek = '$merek', 
                            harga = '$harga', 
                            stok = '$stok', 
                            gambar = '$gambar' 
                        WHERE id = '$edit_id'";

        if (mysqli_query($conn, $update_query)) {
            header("Location: dashboard.php"); // Redirect ke dashboard setelah sukses
            exit;
        } else {
            echo 'Gagal memperbarui data mobil.';
        }
    }
} else {
    echo 'ID mobil tidak ditemukan.';
    exit;
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
<body class="bg-gray-100 min-h-screen font-sans">
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-md">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">Edit Mobil</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="nama" class="block text-gray-700">Nama Mobil</label>
                <input type="text" id="nama" name="nama" class="w-full p-2 border border-gray-300 rounded" value="<?php echo htmlspecialchars($mobil['nama']); ?>" required>
            </div>

            <div class="mb-4">
                <label for="merek" class="block text-gray-700">Merek</label>
                <input type="text" id="merek" name="merek" class="w-full p-2 border border-gray-300 rounded" value="<?php echo htmlspecialchars($mobil['merek']); ?>" required>
            </div>

            <div class="mb-4">
                <label for="harga" class="block text-gray-700">Harga</label>
                <input type="number" id="harga" name="harga" class="w-full p-2 border border-gray-300 rounded" value="<?php echo htmlspecialchars($mobil['harga']); ?>" required>
            </div>

            <div class="mb-4">
                <label for="stok" class="block text-gray-700">Stok</label>
                <input type="number" id="stok" name="stok" class="w-full p-2 border border-gray-300 rounded" value="<?php echo htmlspecialchars($mobil['stok']); ?>" required>
            </div>

            <div class="mb-4">
                <label for="gambar" class="block text-gray-700">Gambar Mobil</label>
                <input type="file" id="gambar" name="gambar" class="w-full p-2 border border-gray-300 rounded">
                <small class="text-gray-500">Biarkan kosong jika tidak mengganti gambar.</small>
                <?php if ($mobil['gambar']): ?>
                    <div class="mt-2">
                        <img src="../assets/images/<?php echo htmlspecialchars($mobil['gambar']); ?>" alt="Gambar Mobil" class="w-32 h-32 object-cover">
                    </div>
                <?php endif; ?>
            </div>

            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-500">Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>
