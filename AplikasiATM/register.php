<?php
require_once 'classes/user.php';
session_start();

// Cek jika form registrasi telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new User();
    $username = htmlspecialchars($_POST['username']);  // Melindungi input dari XSS
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Cek apakah password dan konfirmasi password sama
    if ($password !== $confirm_password) {
        $error_message = "Password dan konfirmasi password tidak cocok.";
    } else {
        // Hash password untuk penyimpanan yang aman
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Cek apakah username sudah ada
        if ($user->checkUsernameExists($username)) {
            $error_message = "Username sudah digunakan.";
        } else {
            // Daftarkan pengguna baru
            if ($user->register($username, $hashed_password)) {
                header("Location: login.php");  // Arahkan ke halaman login setelah registrasi berhasil
                exit();
            } else {
                $error_message = "Terjadi kesalahan saat registrasi. Coba lagi.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sistem ATM</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-teal-500 to-blue-500 flex justify-center items-center h-screen">

    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">Registrasi Akun Baru</h2>
        
        
        <?php if (isset($error_message)): ?>
            <div class="bg-red-500 text-white p-4 rounded-md mb-4"><?php echo $error_message; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" id="username" placeholder="Masukkan username Anda" class="w-full p-3 mt-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" placeholder="Masukkan password Anda" class="w-full p-3 mt-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500" required>
            </div>
            <div class="mb-6">
                <label for="confirm_password" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Konfirmasi password Anda" class="w-full p-3 mt-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500" required>
            </div>
            <button type="submit" class="w-full p-3 bg-teal-600 text-white rounded-md hover:bg-teal-700 transition duration-300">Registrasi</button>
        </form>
        
        <p class="mt-4 text-center text-sm text-gray-600">Sudah punya akun? <a href="login.php" class="text-teal-600 hover:text-teal-700">Login di sini</a></p>
    </div>

</body>
</html>
