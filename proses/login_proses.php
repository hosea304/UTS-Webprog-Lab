<?php
session_start();
require_once('../todo.php');

$username = $_POST['username'];
$password = $_POST['pass'];

$sql = "SELECT * FROM user
        WHERE nama = ?";

$stmt = $db->prepare($sql);
$stmt->execute([$username]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$row) {
    header('Location: ../login.php?not%found');
    exit();
}
else {
    if(!password_verify($password, $row['password'])){
        header('Location: ../login.php?wrong%pass');
        exit();
    }
    else {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['nama'];
        header('Location: ../todo.php');
    }
}