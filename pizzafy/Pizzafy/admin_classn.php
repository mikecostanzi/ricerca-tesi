<?php
session_start();

class Action {
    private $conn;

    public function __construct() {
        include 'db_connect.php';
        $this->conn = $conn;
    }

    public function get_cart_items() {
    if(!isset($_SESSION['login_user_id'])) {
        return ['items' => []];
    }
    
    $user_id = $_SESSION['login_user_id'];
    $items = [];
    
    $sql = $this->conn->query("SELECT c.id as cart_id, c.product_id, c.qty, p.name, p.price 
                               FROM cart c 
                               JOIN product_list p ON c.product_id = p.id 
                               WHERE c.user_id = $user_id");
    
    if($sql) {
        while($row = $sql->fetch_assoc()) {
            $items[] = $row;
        }
    }
    
    return ['items' => $items];
}

    public function add_to_cart() {
        if(!isset($_SESSION['login_user_id'])) return "0";
        
        $pid = $_POST['pid'];
        $qty = $_POST['qty'];
        $user_id = $_SESSION['login_user_id'];
        
        $check = $this->conn->query("SELECT * FROM cart WHERE user_id = $user_id AND pid = $pid");
        
        if($check && $check->num_rows > 0) {
            $row = $check->fetch_assoc();
            $new_qty = $row['qty'] + $qty;
            $this->conn->query("UPDATE cart SET qty = $new_qty WHERE user_id = $user_id AND pid = $pid");
        } else {
            $this->conn->query("INSERT INTO cart (user_id, pid, qty) VALUES ($user_id, $pid, $qty)");
        }
        
        return "1";
    }

    public function delete_cart() {
        if(!isset($_SESSION['login_user_id'])) return "0";
        
        $id = $_POST['id'];
        $this->conn->query("DELETE FROM cart WHERE id = $id");
        return "1";
    }

    public function get_cart_count() {
        if(!isset($_SESSION['login_user_id'])) return "0";
        
        $user_id = $_SESSION['login_user_id'];
        $sql = $this->conn->query("SELECT SUM(qty) as total FROM cart WHERE user_id = $user_id");
        if($sql) {
            $row = $sql->fetch_assoc();
            return $row['total'] ? $row['total'] : "0";
        }
        return "0";
    }

}
?>