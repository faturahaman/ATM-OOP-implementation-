<?php
require_once 'database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    // Mengecek apakah username sudah terdaftar
    public function checkUsernameExists($username) {
        $query = "SELECT * FROM users WHERE username = '$username'"; // Menulis query langsung
        $result = $this->db->query($query);
        return $result->num_rows > 0;  // Kembalikan true jika username sudah ada
    }

    // Mendaftarkan pengguna baru dengan password yang di-hash
    public function register($username, $password) {
        // Hash password menggunakan password_hash
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
        return $this->db->query($query);  // Mengembalikan true jika query berhasil
    }

    public function login($username, $password) {
        // Query database langsung
        $query = "SELECT id, username, password FROM users WHERE username = '$username'";
        $result = $this->db->query($query);

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Membandingkan password secara langsung
            if ($password === $user['password']) {
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $user['id'];  // Menyimpan user_id di session
                $_SESSION['username'] = $user['username']; // Menyimpan username di session
                return true;
            }
        }

        return false; // Username tidak ditemukan atau password tidak cocok
    }

    // Mengambil saldo pengguna berdasarkan user_id
    public function getBalance($user_id) {
        $query = "SELECT balance FROM users WHERE id = $user_id"; // Menulis query langsung
        $result = $this->db->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['balance'];
        }
        return null;  // Jika tidak ada data
    }

    // Menyimpan saldo baru setelah transaksi
    public function updateBalance($user_id, $new_balance) {
        $query = "UPDATE users SET balance = $new_balance WHERE id = $user_id"; // Menulis query langsung
        return $this->db->query($query);
    }
}
?>
