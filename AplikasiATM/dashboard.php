<?php
require_once 'classes/User.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user = new User();
$balance = $user->getBalance($_SESSION['user_id']);


?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem ATM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.0.23/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-r from-teal-500 to-blue-500">

    <div class="container mx-auto p-6">
        <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-lg">
            <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">Dashboard ATM</h2>
            <p class="text-lg text-center text-gray-700 mb-6">Saldo Anda: <span class="font-semibold text-xl text-green-600">Rp. <?php echo number_format($balance, 2); ?></span></p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <a href="deposit.php" class="flex items-center justify-center p-4 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="text-lg">Simpan Uang</span>
                </a>
                <a href="withdraw.php" class="flex items-center justify-center p-4 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="text-lg">Ambil Uang</span>
                </a>
                <a href="logout.php" class="flex items-center justify-center p-4 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H3" />
                    </svg>
                    <span class="text-lg">Logout</span>
                </a>
            </div>
        </div>
    </div>

</body>
</html>
