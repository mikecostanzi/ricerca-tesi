<?php
ob_start();

$action = $_GET['action'];
include 'admin_class_novo.php';
$crud = new Action();

if($action == "get_cart_items"){
    $cart_data = $crud->get_cart_items(); 
    header('Content-Type: application/json');
    echo json_encode($cart_data);
    exit;
}

if($action == "add_to_cart"){
    $save = $crud->add_to_cart();
    echo trim($save);
    exit;
}

if($action == "delete_cart"){
    $delete = $crud->delete_cart();
    echo trim($delete);
    exit;
}

if($action == "get_cart_count"){
    $count = $crud->get_cart_count();
    echo trim($count);
    exit;
}

if($action == 'login'){
	$login = $crud->login();
    print $login;
    exit;
	if($login)
        echo $login;
}
if($action == 'login2'){
	$login = $crud->login2();
	if($login)
		echo $login;
}
if($action == "test_login"){
    echo $crud->test_login();
    exit;
}
if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
		echo $logout;
}
if($action == 'logout2'){
	$logout = $crud->logout2();
	if($logout)
		echo $logout;
}
if($action == 'save_user'){
    $save = $crud->save_user();
    if($save) echo $save;
}
if($action == 'signup'){
    $save = $crud->signup();
    if($save) echo $save;
}
if($action == "save_settings"){
    $save = $crud->save_settings();
    if($save) echo $save;
}
if($action == "save_category"){
    $save = $crud->save_category();
    if($save) echo $save;
}
if($action == "delete_category"){
    $save = $crud->delete_category();
    if($save) echo $save;
}
if($action == "save_menu"){
    $save = $crud->save_menu();
    if($save) echo $save;
}
if($action == "delete_menu"){
    $save = $crud->delete_menu();
    if($save) echo $save;
}
if($action == "update_cart_qty"){
    $save = $crud->update_cart_qty();
    if($save) echo $save;
}
if($action == "save_order"){
    $save = $crud->save_order();
    if($save) echo $save;
}
if($action == "confirm_order"){
    $save = $crud->confirm_order();
    if($save) echo $save;
}
?>