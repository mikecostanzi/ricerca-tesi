<?php
session_start();
include 'admin/db_connect.php';

if(!isset($_SESSION['login_user_id'])) {
    header('Location: index.php');
    exit;
}

$pid = $_POST['pid'];
$qty = $_POST['qty'];
$user_id = $_SESSION['login_user_id'];

$check = $conn->query("SELECT * FROM cart WHERE user_id = $user_id AND pid = $pid");

if($check->num_rows > 0) {
    $row = $check->fetch_assoc();
    $new_qty = $row['qty'] + $qty;
    $conn->query("UPDATE cart SET qty = $new_qty WHERE user_id = $user_id AND pid = $pid");
} else {
    $conn->query("INSERT INTO cart (user_id, pid, qty) VALUES ($user_id, $pid, $qty)");
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>