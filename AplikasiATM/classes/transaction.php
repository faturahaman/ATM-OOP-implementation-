<?php
require_once 'Database.php';

class Transaction {
    private $db;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    public function deposit($user_id, $amount) {
        $user_id = (int) $user_id;
        $amount = (float) $amount;
        
        $query = "UPDATE users SET balance = balance + $amount WHERE id = $user_id";
        $this->db->query($query);

        $query = "INSERT INTO transactions (user_id, type, jumlah) VALUES ($user_id, 'deposit', $amount)";
        return $this->db->query($query);
    }

    public function withdraw($user_id, $amount) {
        $user_id = (int) $user_id;
        $amount = (float) $amount;

        $query = "SELECT balance FROM users WHERE id = $user_id";
        $result = $this->db->query($query);
        $row = $result->fetch_assoc();
        
        if ($row && $row['balance'] >= $amount) {
            $query = "UPDATE users SET balance = balance - $amount WHERE id = $user_id";
            $this->db->query($query);

            $query = "INSERT INTO transactions (user_id, type, jumlah) VALUES ($user_id, 'withdraw', $amount)";
            return $this->db->query($query);
        }
        return false;
    }

    public function transfer($from_user_id, $to_username, $amount) {
        $from_user_id = (int) $from_user_id;
        $amount = (float) $amount;
        $to_username = mysqli_real_escape_string($this->db, $to_username);
    
        $query = "SELECT balance FROM users WHERE id = $from_user_id";
        $result = $this->db->query($query);
        $user = $result->fetch_assoc();
    
        if (!$user || $user['balance'] < $amount) {
            return false;
        }
    
        $query = "SELECT id FROM users WHERE username = '$to_username'";
        $result = $this->db->query($query);
        $recipient = $result->fetch_assoc();
        if (!$recipient) {
            return false;
        }

        $to_user_id = (int) $recipient['id'];
        $query = "UPDATE users SET balance = balance - $amount WHERE id = $from_user_id";
        $this->db->query($query);
    
        $query = "UPDATE users SET balance = balance + $amount WHERE id = $to_user_id";
        $this->db->query($query);
    
       $query = "INSERT INTO transactions (user_id, type, jumlah) VALUES ($from_user_id, 'transfer', $amount)";

        return $this->db->query($query);
    }
}
?>
    
