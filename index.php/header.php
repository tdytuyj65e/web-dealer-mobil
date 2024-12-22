<?php
include '../inc/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dealer Mobil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Styling logo */
        .logo-container {
            display: flex;
            align-items: center;
            font-size: 1.5rem;
            font-weight: bold;
            color: #ffffff;
        }
        .logo-icon {
            width: 30px;
            height: 30px;
            background-color: #fff;
            border-radius: 50%;
            margin-right: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .logo-icon svg {
            width: 18px;
            height: 18px;
            fill: #2c7a32; /* Green color */
        }
    </style>
    <script>
        function toggleMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
    </script>
</head>
<body class="bg-gray-100 font-sans">
    <!-- Navbar -->
    <nav class="bg-green-700 text-white shadow-md">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0 logo-container">
                    <!-- Icon -->
                    <div class="logo-icon">
                        <!-- SVG mobil icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M6 19c-1.1 0-1.99.9-1.99 2S4.9 23 6 23s2-.9 2-2-.9-2-2-2zm12 0c-1.1 0-1.99.9-1.99 2S16.9 23 18 23s2-.9 2-2-.9-2-2-2zM5 9V6c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2v3h2v5h-1v2h-1v-1h-10v1h-1v-2H5V9h2zm4-2h6V6H9v1z"/>
                        </svg>
                    </div>
                    <!-- Teks Logo -->
                    <span>Dealer Mobil</span>
                </div>

                <!-- Hamburger menu (Mobile) -->
                <div class="md:hidden flex items-center">
                    <button onclick="toggleMenu()" class="text-white focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                </div>

                <!-- Menu (Desktop) -->
                <div class="hidden md:flex space-x-8">
                    <a href="tabel_penjualan.php" class="hover:text-green-300 transition duration-200">Beranda</a>
                    <a href="input_penjualan.php" class="hover:text-green-300 transition duration-200">Penjualan</a>
                    <a href="halaman_input.php" class="hover:text-green-300 transition duration-200">Input Mobil</a>
                    <a href="index.php" class="hover:text-green-300 transition duration-200">Data Penjualan</a>
                    <a href="anggota.php" class="hover:text-green-300 transition duration-200">Anggota</a>
                    <a href="data_mobil.php" class="hover:text-green-300 transition duration-200">Data Mobil</a>
                    <a href="pendapatan_perbulan.php" class="hover:text-green-300 transition duration-200">Pendapatan Per Bulan</a>
                </div>
            </div>

            <!-- Menu (Mobile) -->
            <div id="mobile-menu" class="hidden md:hidden mt-4">
                <a href="tabel_penjualan.php" class="block py-2 hover:bg-green-600 px-3 rounded">Beranda</a>
                <a href="input_penjualan.php" class="block py-2 hover:bg-green-600 px-3 rounded">Penjualan</a>
                <a href="halaman_input.php" class="block py-2 hover:bg-green-600 px-3 rounded">Input Mobil</a>
                <a href="index.php" class="block py-2 hover:bg-green-600 px-3 rounded">Data Penjualan</a>
                <a href="anggota.php" class="block py-2 hover:bg-green-600 px-3 rounded">Anggota</a>
                <a href="data_mobil.php" class="block py-2 hover:bg-green-600 px-3 rounded">Data Mobil</a>
                <a href="pendapatan_perbulan.php" class="block py-2 hover:bg-green-600 px-3 rounded">Pendapatan Per Bulan</a>
            </div>
        </div>
    </nav>

    <!-- Content -->
    
</body>
</html>
