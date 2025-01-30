<?php
require_once 'database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    // Mengecek apakah username sudah terdaftar
    public function checkUsernameExists($username) {
        $query = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $query->bind_param('s', $username);
        $query->execute();
        $result = $query->get_result();
        return $result->num_rows > 0;  // Kembalikan true jika username sudah ada
    }

    // Mendaftarkan pengguna baru dengan password yang di-hash
    public function register($username, $password) {
        // Hash password menggunakan password_hash
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = $this->db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $query->bind_param('ss', $username, $hashed_password);
        return $query->execute();  // Mengembalikan true jika query berhasil
    }

    // Login dan verifikasi password dengan password_verify
    public function login($username, $password) {
        $query = $this->db->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $query->bind_param('s', $username);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            // Verifikasi password dengan password_verify
            if (password_verify($password, $user['password'])) {
                session_start();  // Pastikan session dimulai sebelum melakukan header atau output lainnya
                $_SESSION['user_id'] = $user['id'];
                return true;  // Login berhasil
            }
        }
        return false;  // Login gagal
    }

    // Mengambil saldo pengguna berdasarkan user_id
    public function getBalance($user_id) {
        $query = $this->db->prepare("SELECT balance FROM users WHERE id = ?");
        $query->bind_param('i', $user_id);  // Menjamin user_id adalah integer
        $query->execute();
        $result = $query->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['balance'];
        }
        return null;  // Jika tidak ada data
    }

    // Menyimpan saldo baru setelah transaksi
    public function updateBalance($user_id, $new_balance) {
        $query = $this->db->prepare("UPDATE users SET balance = ? WHERE id = ?");
        $query->bind_param('di', $new_balance, $user_id);  // 'd' untuk double (angka desimal)
        return $query->execute();
    }
}
?>
