<?php
// lupa_password.php
session_start();

if (!isset($db)) {
  $db = new PDO("mysql:host=localhost;dbname=todo", "root", "");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $new_password = $_POST['new_password'];
  $confirm_password = $_POST['confirm_password'];

  if ($new_password !== $confirm_password) {
    $_SESSION['error'] = "Password baru dan konfirmasi password tidak cocok.";
    header('Location: ../lupa.php');
    exit();
  }

  $sql = "SELECT * FROM user WHERE nama = ?";
  $stmt = $db->prepare($sql);
  $stmt->execute([$username]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$user) {
    $_SESSION['error'] = "Username tidak ditemukan.";
    header('Location: ../lupa.php');
    exit();
  }

  $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
  $sql = "UPDATE user SET password = ? WHERE nama = ?";
  $stmt = $db->prepare($sql);
  $stmt->execute([$hashed_password, $username]);

  $_SESSION['success'] = "Password berhasil diubah.";
  header('Location: ../login.php');
}

?>