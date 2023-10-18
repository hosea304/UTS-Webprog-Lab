<?php
$koneksi = mysqli_connect("localhost", "root", "", "todo");

if (mysqli_connect_errno()) {
  die("Koneksi database gagal: " . mysqli_connect_error() . "(" . mysqli_connect_errno() . ")");
}

if (isset($_POST['submit'])) {
  $tugas = $_POST['listBaru'];
  $priority = $_POST['priority'];

  $tugas = mysqli_escape_string($koneksi, $tugas);
  $priority = mysqli_escape_string($koneksi, $priority);

  $sql = "INSERT INTO tbl_tugas (priority, tugas, status)
          VALUES ('{$priority}', '{$tugas}', 'No Status')";
  mysqli_query($koneksi, $sql);
}

if (isset($_POST['check'])) {
  $id = $_POST['id'];
  $isChecked = $_POST['check'] == 1 ? 1 : 0;
  $sql = "UPDATE tbl_tugas SET status='" . ($isChecked ? 'Done' : 'On Progress') . "' WHERE id = $id";
  mysqli_query($koneksi, $sql);
}

$sql = "SELECT * FROM tbl_tugas ORDER BY priority DESC, status ASC";
$hasil = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>To Do List App</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Pacifico" />
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="container-fluid">
    <div class='d-flex justify-content-center align-items-center w-100 h-100 flex-column'>
      <h1 class="mb-3">To-do list</h1>
      <form action="todo.php" method='POST' class="mb-3">
        <label>New To Do</label>
        <input type="text" name="listBaru" id="listBaru" required>
        <select name="priority" id="option">
          <option value="High">High</option>
          <option value="Medium">Medium</option>
          <option value="Low">Low</option>
        </select>
        <input type="submit" value="Add" class="Add rounded-3" name="submit">
      </form>

      <table class="table table-sm">
        <thead class="table-primary">
          <tr>
            <th scope="col">Priority</th>
            <th scope="col">Task</th>
            <th scope="col">Progress</th>
            <th scope="col">Update</th>
            <th scope="col">Done</th>
          </tr>
        </thead>
        <tbody>
          <?php
          while ($baris = mysqli_fetch_assoc($hasil)) {
            echo "<tr>";
            echo "<td scope='row'>";
            echo $baris['priority'];
            echo "</td>";

            echo "<td scope='row'>";
            echo $baris['tugas'];
            echo "</td>";

            echo "<td scope='row'>";
            echo $baris['status'];
            echo "</td>";

            echo "<td>";
            echo "<a href='start.php?id=" . $baris['id'] . "'>Start</a> |";
            echo "<a href='cancel.php?id=" . $baris['id'] . "'>Cancel</a> |";
            echo "<a href='delete.php?id=" . $baris['id'] . "'>Delete</a> |";
            echo "</td>";

            echo "<td>";
            echo "<form action='todo.php' method='POST'>";
            echo "<input type='checkbox' name='check' onchange='this.form.submit()' " . ($baris['status'] == 'Done' ? 'checked' : '') . ">";
            echo "<input type='hidden' name='id' value='" . $baris['id'] . "'>";
            echo "</form>";
            echo "</td>";

            echo "</tr>";
          }

          mysqli_free_result($hasil);
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>
</body>

</html>

<?php
mysqli_close($koneksi);
?>