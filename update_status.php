<?php
$koneksi = mysqli_connect("localhost", "root", "", "todo");

if (mysqli_connect_errno()) {
  die("Koneksi database gagal: " . mysqli_connect_error() . "(" . mysqli_connect_errno() . ")");
}

if (isset($_POST['id']) && isset($_POST['status'])) {
  $id = htmlspecialchars($_POST['id']);
  $status = htmlspecialchars($_POST['status']);

  $sql = "UPDATE tbl_tugas SET status = ? WHERE id = ?";
  $stmt = $koneksi->prepare($sql);
  $stmt->bind_param("si", $status, $id);
  $stmt->execute();
  $stmt->close();
}

mysqli_close($koneksi);
?>