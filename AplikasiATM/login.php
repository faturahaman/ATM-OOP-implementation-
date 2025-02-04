<?php
require_once 'classes/User.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new User();
    $username = htmlspecialchars($_POST['username']); 
    $password = $_POST['password'];

    if ($user->login($username, $password)) {
        header("Location: dashboard.php");
        exit();
    } else {
        $error_message = "Login gagal. Periksa username dan password Anda!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem ATM</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-blue-500 to-teal-500 flex justify-center items-center h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">Selamat Datang di Sistem ATM</h2>
        
        <?php if (isset($error_message)): ?>
            <div class="bg-red-500 text-white p-4 rounded-md mb-4"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" id="username" required
                       class="w-full p-3 mt-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" required
                       class="w-full p-3 mt-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="w-full p-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-300">Login</button>
            <p class="mt-2">Tidak punya akun? <a href="register.php" class="text-blue-400">Daftar!</a></p>
        </form>
    </div>
</body>
</html>
