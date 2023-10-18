<?php
$koneksi = mysqli_connect("localhost", "root", "", "todo");

if (mysqli_connect_errno()) {
  die("Koneksi database gagal: " . mysqli_connect_error() . "(" . mysqli_connect_errno() . ")");
}

if (isset($_POST['check']) && isset($_POST['id'])) {
  $id = $_POST['id'];
  $isChecked = $_POST['check'] == 1 ? 1 : 0;
  $sql = "UPDATE tbl_tugas SET status='" . ($isChecked ? 'Done' : 'On Progress') . "' WHERE id = $id";
  if (mysqli_query($koneksi, $sql)) {
    echo "Tugas berhasil diperbarui";
  } else {
    echo "Gagal memperbarui tugas: " . mysqli_error($koneksi);
  }
}

mysqli_close($koneksi);
?>