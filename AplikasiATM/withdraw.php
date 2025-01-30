<?php
require_once 'classes/transaction.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transaction = new Transaction();
    if ($transaction->withdraw($_SESSION['user_id'], $_POST['amount'])) {
        echo "<div class='bg-red-500 text-white p-4 rounded-md mb-4'>Uang berhasil diambil.</div>";
    } else {
        echo "<div class='bg-yellow-500 text-white p-4 rounded-md mb-4'>Saldo tidak cukup.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ambil Uang - Sistem ATM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.0.23/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-r from-red-500 to-orange-500">

    <div class="w-full max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg mt-10">
        <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">Ambil Uang</h2>
        <form method="POST">
            <div class="mb-6">
                <label for="amount" class="block text-sm font-medium text-gray-700">Jumlah</label>
                <input type="number" name="amount" id="amount" placeholder="Masukkan jumlah uang yang ingin diambil" class="w-full p-3 mt-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500" required>
            </div>
            <button type="submit" class="w-full p-3 bg-red-600 text-white rounded-md hover:bg-red-700 transition duration-300">Ambil</button>
        </form>
    </div>

</body>
</html>
