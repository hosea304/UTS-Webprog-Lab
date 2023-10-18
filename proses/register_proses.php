<?php
require_once ('../todo.php');

if (
    !isset($_POST['username']) || empty($_POST['username']) ||
    !isset($_POST['pass']) || empty($_POST['pass']) ||
    !isset($_POST['confirm']) || empty($_POST['confirm']) 
) {
    header('Location: ../register.php?error=1');
    exit();
}
else {
    $username = $_POST['username'];
    $pass_tmp = $_POST['pass'];
    $confirm = $_POST['confirm'];
    if ($confirm == $pass_tmp){
        $password = $pass_tmp;
    }
    else {
        header('Location: ../register.php?error=2');
        exit();
    }
}

$en_pass = password_hash($password, PASSWORD_BCRYPT);

$sql = "INSERT INTO user (nama, password)
        VALUES (?, ?)";

$stmt = $todo->prepare($sql);
$data = [$username, $en_pass];
$stmt->execute($data);

header('Location: ../login.php');
