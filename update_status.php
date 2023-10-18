<?php
$koneksi = mysqli_connect("localhost", "root", "", "todo");

if (mysqli_connect_errno()) {
  die("Koneksi database gagal: " . mysqli_connect_error() . "(" . mysqli_connect_errno() . ")");
}

if (isset($_POST['id']) && isset($_POST['status'])) {
  $id = $_POST['id'];
  $status = $_POST['status'];

  $sql = "UPDATE tbl_tugas SET status = '$status' WHERE id = $id";
  mysqli_query($koneksi, $sql);
}

mysqli_close($koneksi);
?>