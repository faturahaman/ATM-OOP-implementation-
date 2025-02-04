<?php
require_once 'classes/User.php';
require_once 'classes/Transaction.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user = new User();
$transaction = new Transaction();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $to_username = $_POST['to_username'];
    $amount = $_POST['amount'];

    // Handle the transfer logic
    if ($transaction->transfer($_SESSION['user_id'], $to_username, $amount)) {
        $message = "Transfer berhasil!";
    } else {
        $message = "Transfer gagal, pastikan saldo cukup dan username tujuan valid.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer - Sistem ATM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.0.23/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-r from-teal-500 to-blue-500">

    <div class="container mx-auto p-6">
        <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-lg">
            <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">Transfer Uang</h2>
            
            <?php if (isset($message)): ?>
                <p class="text-center text-lg text-green-600 mb-4"><?php echo $message; ?></p>
            <?php endif; ?>

            <form method="POST" class="space-y-4">
                <div>
                    <label for="to_username" class="block text-lg text-gray-700">Username Tujuan</label>
                    <input type="text" name="to_username" id="to_username" class="w-full p-3 border border-gray-300 rounded-lg" required>
                </div>
                <div>
                    <label for="amount" class="block text-lg text-gray-700">Jumlah Uang</label>
                    <input type="number" name="amount" id="amount" class="w-full p-3 border border-gray-300 rounded-lg" required>
                </div>
                <div class="flex gap-2">

                    <div class="text-center">
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">Transfer</button>
                    </div>
                    <div class="text-center">
                        <a href="dashboard.php">
                            <div class="px-6 w-fit mx-auto py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">cancel</div>
                        </a>
                    </div>
                </div>
            </form>
            
        </div>
    </div>

</body>
</html>
