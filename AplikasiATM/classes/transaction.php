<?php
require_once 'Database.php';

class Transaction {
    private $db;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    public function deposit($user_id, $amount) {
        $query = "UPDATE users SET balance = balance + $amount WHERE id=$user_id";
        $this->db->query($query);

        $query = "INSERT INTO transactions (user_id, type, jumlah) VALUES ($user_id, 'deposit', $amount)";
        return $this->db->query($query);
    }

    public function withdraw($user_id, $amount) {
        $query = "SELECT balance FROM users WHERE id=$user_id";
        $result = $this->db->query($query);
        $row = $result->fetch_assoc();
        
        if ($row['balance'] >= $amount) {
            $query = "UPDATE users SET balance = balance - $amount WHERE id=$user_id";
            $this->db->query($query);

            $query = "INSERT INTO transactions (user_id, type, jumlah) VALUES ($user_id, 'withdraw', $amount)";
            return $this->db->query($query);
        }
        return false;
    }
}
?>
