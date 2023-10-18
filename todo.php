<?php
$koneksi = mysqli_connect("localhost", "root", "", "todo");

if (mysqli_connect_errno()) {
  die("Koneksi database gagal: " . mysqli_connect_error() . "(" . mysqli_connect_errno() . ")");
}

if (isset($_POST['submit'])) {
  $tugas = $_POST['listBaru'];
  $priority = $_POST['priority'];

  switch ($priority) {
    case 'High':
      $priority = 3;
      break;
    case 'Medium':
      $priority = 2;
      break;
    case 'Low':
      $priority = 1;
      break;
  }

  $tugas = mysqli_escape_string($koneksi, $tugas);
  $priority = mysqli_escape_string($koneksi, $priority);

  $sql = "INSERT INTO tbl_tugas (priority, tugas, status)
          VALUES ('{$priority}', '{$tugas}', 'No Status')";
  mysqli_query($koneksi, $sql);
}

if (isset($_POST['task_done'])) {
  $id = $_POST['id'];
  $isChecked = $_POST['task_done'] ? 1 : 0;

  // Update status to 'Done' if checked, 'On Progress' if unchecked
  $status = $isChecked ? 'Done' : 'On Progress';

  $sql = "UPDATE tbl_tugas SET status = '$status' WHERE id = $id";
  mysqli_query($koneksi, $sql);
}

// Modify SQL query to order by status and then priority
$sql = "SELECT * FROM tbl_tugas ORDER BY FIELD(status, 'On Progress', 'Done', 'No Status'), priority DESC";
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
            // Convert priority back to string for display
            switch ($baris['priority']) {
              case 3:
                echo 'High';
                break;
              case 2:
                echo 'Medium';
                break;
              case 1:
                echo 'Low';
                break;
            }
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
            echo "<input type='checkbox' name='task_done' onchange='this.form.submit()' " . ($baris['status'] == 'Done' ? 'checked' : '') . ($baris['status'] == 'No Status' ? 'disabled' : '') . ">";
            echo "<input type='hidden' name='id' value='" . $baris['id'] . "'>";
            echo "</td>";


            echo "</tr>";
          }

          mysqli_free_result($hasil);
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <script>
    $(document).ready(function () {
      $('input[type="checkbox"]').on('change', function () {
        var id = $(this).next().val();
        var isChecked = $(this).is(':checked');
        var status = isChecked ? 'Done' : 'On Progress';

        $.post('update_status.php', { id: id, status: status }, function (data) {
          location.reload();
        });
      });
    });
  </script>

</body>

</html>

<?php
mysqli_close($koneksi);
?>