<?php
session_start();
class Action {
    private $conn;

    public function __construct() {
        include 'db_connect.php';
        $this->conn = $conn;
    }

    public function add_to_cart() {
    if(!isset($_SESSION['login_user_id'])) return "0";
    
    $product_id = $_POST['pid'];
    $qty = (int)$_POST['qty'];
    $user_id = $_SESSION['login_user_id'];
    $client_ip = $_SERVER['REMOTE_ADDR'];
    
    $sql_check = "SELECT * FROM cart WHERE user_id = $user_id AND product_id = $product_id";
    $check = $this->conn->query($sql_check);

    if (!$check) {
        return $this->conn->error;
    }
    
    if(!$check) {

        $sql_lower = strtolower($sql_check);
        if(strpos($sql_lower, "union") !== false || 
           strpos($sql_lower, "sleep") !== false || 
           strpos($sql_lower, "extractvalue") !== false ||
           strpos($sql_lower, "updatexml") !== false ||
           preg_match("/'[^']*'[^']*'/", $sql_check)) {
            return $this->conn->error;
        }
        return "0";
    }
    
    if($check->num_rows > 0) {
        $row = $check->fetch_assoc();
        $new_qty = $row['qty'] + $qty;
        $sql_update = "UPDATE cart SET qty = $new_qty WHERE user_id = $user_id AND product_id = $product_id";
        $update = $this->conn->query($sql_update);
        if(!$update) {
            return "0";
        }
    } else {
        $sql_insert = "INSERT INTO cart (user_id, product_id, qty, client_ip) VALUES ($user_id, $product_id, $qty, '$client_ip')";
        $insert = $this->conn->query($sql_insert);
        if(!$insert) {
            return "0";
        }
    }
    
    return "1";
}

public function get_cart_items() {
    if(!isset($_SESSION['login_user_id'])) {
        return ['items' => []];
    }
    
    $user_id = $_SESSION['login_user_id'];
    
    if (isset($_GET['id'])) {
        $user_id = $_GET['id'];            
    }
    
    $sql = "SELECT c.id as cart_id, c.product_id, c.qty, p.name, p.price 
            FROM cart c 
            JOIN product_list p ON c.product_id = p.id 
            WHERE c.user_id = $user_id";
    
    $result = $this->conn->query($sql);    
    
    if (!$result) {    
        return ['items' => [], 'error' => $this->conn->error];
    }

    $items = [];
    $total = 0;
    
    if($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $subtotal = $row['price'] * $row['qty'];
            $total += $subtotal;
            $items[] = [
                'cart_id' => $row['cart_id'],
                'product_id' => $row['product_id'],
                'name' => $row['name'],
                'qty' => $row['qty'],
                'price' => (float)$row['price'],
                'subtotal' => (float)$subtotal
            ];
        }
    }
    
    return ['items' => $items, 'total' => $total];
}

    public function delete_cart() {
        if(!isset($_SESSION['login_user_id'])) return "0";
        
        $id = $_POST['id'];
        $result = $this->conn->query("DELETE FROM cart WHERE id = $id");

         if(!$result) {
            return $this->conn->error;
         }

        return "1";
    }

    
    public function get_cart_count() {
    if(!isset($_SESSION['login_user_id'])) return "0";
    
    $user_id = $_SESSION['login_user_id'];
    
    if (isset($_GET['id'])) {
        $user_id = $_GET['id'];            
    }
    
    $sql = "SELECT SUM(qty) as total FROM cart WHERE user_id = $user_id";
    $result = $this->conn->query($sql);    
    
    if (!$result) {    
        return $this->conn->error;
    }

    if($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
 
        if(!is_numeric($row['total'])) {
            return json_encode($row);
        }
        
        return $row['total'] ? (string)$row['total'] : "0";
    }
    
    return "0";
}

    public function update_cart_qty() {
        if(!isset($_SESSION['login_user_id'])) return "0";
        
        $id = $_POST['id'];
        $qty = (int)$_POST['qty'];
        
        $this->conn->query("UPDATE cart SET qty = $qty WHERE id = $id");
        return "1";
    }
   
public function login() {
    
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';    
    
    $qry = $this->conn->query("SELECT * FROM users WHERE username = '$username'");

    if (!$qry) {    
        return $this->conn->error;
    }
    
    if($qry && $qry->num_rows > 0) {
        
        $row = $qry->fetch_assoc();        

        if(password_verify($password, $row['password'])) {
            $_SESSION['login_id'] = $row['id'];
            $_SESSION['login_name'] = $row['name'];
            $_SESSION['login_type'] = $row['type'];
            return 1;
        }
        return json_encode($row);
        
        } else {
        return 2;
    }
}

public function login2() {
    $username = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    
    $sql = "SELECT * FROM user_info WHERE email = '$username'";
    $qry = $this->conn->query($sql);
    
    if (!$qry) {    
        return $this->conn->error;
    }
    
    if($qry && $qry->num_rows > 0) {
        $row = $qry->fetch_assoc();
        
        if(password_verify($password, $row['password'])) {
            $_SESSION['login_user_id'] = $row['user_id'];
            $_SESSION['login_first_name'] = $row['first_name'];
            $_SESSION['login_last_name'] = $row['last_name'];            
            return 1;
        }
        
        return json_encode($row);
        
    } else {
        return 2;
    }
}

    public function logout() {
        session_destroy();
        header("Location: ../index.php");
        exit;
    }

    public function logout2() {
    session_destroy();
    header("Location: ../index.php");
    exit;
}

    public function save_user() {

    if(!isset($_SESSION['login_id'])) {
        return 2;
    }    
    extract($_POST);

    if(!empty($id)) {
        $check = $this->conn->query("SELECT * FROM users WHERE (username = '$username') AND id != $id");
    } else {
        $check = $this->conn->query("SELECT * FROM users WHERE username = '$username'");
    }

    if (!$check) {
        return $this->conn->error;
    }
    
    if($check->num_rows > 0) {
        return 3;
    }
    
 
    $data = " name = '$name' ";
    $data .= ", username = '$username' ";
    $data .= ", type = '$type' ";
    
 
    if(!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $data .= ", password = '$hashed_password' ";
    }
    
 
    if(empty($id)) {
 
        $save = $this->conn->query("INSERT INTO users SET $data");
        if($save) {
            return 1;
        } else {
            return 0;
        }
    } else {
 
        $save = $this->conn->query("UPDATE users SET $data WHERE id = $id");
        if($save) {
            return 1;
        } else {
            return 0;
        }
    }
}

    public function signup() {
        // sua função existente
    }

    public function save_settings() {
    extract($_POST);
    
    // Verificar se o usuário está logado
    if(!isset($_SESSION['login_id'])) {
        return 2;
    }
    
    
    $qry = $this->conn->query("SELECT * FROM system_settings WHERE id = 1");
    $current = $qry->fetch_assoc();
    
    $cover_img = $current['cover_img'];
    if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != '') {
        $target_dir = "../assets/img/";
        $file_name = $_FILES['img']['name'];
        $target_file = $target_dir . $file_name;
        
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));        
        
        
            if(move_uploaded_file($_FILES['img']['tmp_name'], $target_file)) {
                $cover_img = $file_name;
     
                if($current['cover_img'] != '' && file_exists($target_dir . $current['cover_img'])) {
                    unlink($target_dir . $current['cover_img']);
        
            }
        }
    }    

    if(isset($_FILES['logo']) && $_FILES['logo']['tmp_name'] != '') {        
        $target_dir = "../assets/img/";
        $file_name = $_FILES['logo']['name'];
        $target_file = $target_dir . $file_name;
        
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        
            if(move_uploaded_file($_FILES['logo']['tmp_name'], $target_file)) {
                $logo = $file_name;
                if($current['logo'] != '' && file_exists($target_dir . $current['logo'])) {
                    unlink($target_dir . $current['logo']);
        
            }
        }
    }
    
    // Dados para atualização
    $data = " name = '$name' ";
    $data .= ", email = '$email' ";
    $data .= ", contact = '$contact' ";
    $data .= ", about_content = '$about' ";
    $data .= ", cover_img = '$cover_img' ";
    
    // Atualizar configurações
    $update = $this->conn->query("UPDATE system_settings SET $data WHERE id = 1");

    if (!$update) {
        return $this->conn->error;
    }
    
    if($update) {
        // Atualizar variáveis de sessão
        $_SESSION['setting_name'] = $name;
        $_SESSION['setting_email'] = $email;
        $_SESSION['setting_contact'] = $contact;
        $_SESSION['setting_about'] = $about;
        $_SESSION['setting_cover_img'] = $cover_img;
        
        return 1;
    } else {
        return 0;
    }
}

    function save_category(){
		extract($_POST);
		$data = " name = '$name' ";
		if(empty($id)){
			$save = $this->conn->query("INSERT INTO category_list set ".$data);
		}else{
			$save = $this->conn->query("UPDATE category_list set ".$data." where id=".$id);
		}
		if($save) {
			return 1;
        } else {
            return $this->conn->error;
        }
	}

    function delete_category(){
		extract($_POST);
		$delete = $this->conn->query("DELETE FROM category_list where id = ".$id);
		if($delete) {
			return 1;
        } else {
            return $this->conn->error;
        }
	}

    

    function save_menu(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", price = '$price' ";
		$data .= ", category_id = '$category_id' ";
		$data .= ", description = '$description' ";
		if(isset($status) && $status  == 'on')
		$data .= ", status = 1 ";
		else
		$data .= ", status = 0 ";

		if($_FILES['img']['tmp_name'] != ''){
						$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
						$move = move_uploaded_file($_FILES['img']['tmp_name'],'../assets/img/'. $fname);
					$data .= ", img_path = '$fname' ";

		}
		if(empty($id)){
			$save = $this->conn->query("INSERT INTO product_list set ".$data);
		}else{
			$save = $this->conn->query("UPDATE product_list set ".$data." where id=".$id);
		}
		if($save) {
			return 1;
        }
        else {
            return $this->conn->error;
        }
	}

	function delete_menu(){
		extract($_POST);
		$delete = $this->conn->query("DELETE FROM product_list where id = ".$id);
		if($delete) {
			return 1;
        }
        else {
            return $this->conn->error;
        }
	}

    public function delete_user() {
    $id = $_POST['id'];
    
    if($id == $_SESSION['login_id']) {
        return 2;
    }
    
    $delete = $this->conn->query("DELETE FROM users WHERE id = $id");

        if(!$result) {
            return $this->conn->error;
         }
    
    if($delete) {
        return 1;
    } else {
        return 0;
    }
}

    
    public function save_order() {
    if(!isset($_SESSION['login_user_id'])) {
        return "0";
    }
    
    extract($_POST);
    $user_id = $_SESSION['login_user_id'];
    $name = $first_name . ' ' . $last_name;

    if (empty($id)) {
        $id = $_SESSION['login_user_id'];
    }
    
    // Buscar itens do carrinho
    $cart_items = $this->conn->query("SELECT c.*, p.price, p.name 
                                       FROM cart c 
                                       JOIN product_list p ON c.product_id = p.id 
                                       WHERE c.user_id = $id OR c.user_id = $user_id");

    if (!$cart_items) {
        return $this->conn->error;
    }                                      
    
    if($cart_items->num_rows == 0) {
        return "0";
    }
    
    // Inserir pedido na tabela orders
    $order_data = " name = '$name' ";
    $order_data .= ", address = '$address' ";
    $order_data .= ", mobile = '$mobile' ";
    $order_data .= ", email = '$email' ";
    $order_data .= ", status = 0 ";
    
    $save_order = $this->conn->query("INSERT INTO orders SET $order_data");
    
    if($save_order) {
        $order_id = $this->conn->insert_id;        
    
        $cart_items = $this->conn->query("SELECT c.*, p.price 
                                           FROM cart c 
                                           JOIN product_list p ON c.product_id = p.id 
                                           WHERE c.user_id = $user_id");
        
        while($row = $cart_items->fetch_assoc()) {
            $item_data = " order_id = '$order_id' ";
            $item_data .= ", product_id = '{$row['product_id']}' ";
            $item_data .= ", qty = '{$row['qty']}' ";
            
            $this->conn->query("INSERT INTO order_list SET $item_data");
        }
        
        // Limpar carrinho
        $this->conn->query("DELETE FROM cart WHERE user_id = $user_id");
        
        return "1";
    }
    
    return "0";
}

public function confirm_order() {
    $id = $_POST['id'];
    $update = $this->conn->query("UPDATE orders SET status = 1 WHERE id = $id");
    
    if($update) {
        return "1";
    }
    return "0";
}
    
}
?>