<?php
require_once 'classes/transaction.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transaction = new Transaction();
    $transaction->deposit($_SESSION['user_id'], $_POST['amount']);
    echo "<div class='bg-green-500 text-white p-4 rounded-md mb-4'>Saldo berhasil ditambahkan.</div>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simpan Uang - Sistem ATM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.0.23/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-r from-teal-500 to-blue-500">

    <div class="w-full max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg mt-10">
        <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">Simpan Uang</h2>
        <form method="POST">
            <div class="mb-6">
                <label for="amount" class="block text-sm font-medium text-gray-700">Jumlah</label>
                <input type="number" name="amount" id="amount" placeholder="Masukkan jumlah uang yang ingin disimpan" class="w-full p-3 mt-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <button type="submit" class="w-full p-3 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-300">Simpan</button>
        </form>
    </div>

</body>
</html>
