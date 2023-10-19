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

  $stmt = $koneksi->prepare("INSERT INTO tbl_tugas (priority, tugas, status) VALUES (?, ?, 'No Status')");
  $stmt->bind_param("is", $priority, $tugas);

  $stmt->execute();
}

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
  <link rel="stylesheet" href="../script/style.css">
</head>

<body>
  <div class="container-fluid">
    <div class='d-flex justify-content-center align-items-center w-100 h-100 flex-column'>
      <h1 class="mb-3">To-do list</h1>
      <form action="edit.php" method='POST' class="mb-3">
        <label>New To Do</label>
        <input type="hidden" name="id" id="id" required>
        <input type="text" name="tugas" id="tugas" required>
        <select name="priority" id="priority">
          <option value="High">High</option>
          <option value="Medium">Medium</option>
          <option value="Low">Low</option>
        </select>
        <select name="status" id="status">
          <option value="No Status">No Status</option>
          <option value="On Progress">On Progress</option>
          <option value="Done">Done</option>
        </select>
        <input type="submit" value="Save" class="Add rounded-3" name="submit">
      </form>
      <div class="table-container">
        <div class="table-container">
          <table class="table scrollable-table">
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
              $delay = 0;
              while ($baris = mysqli_fetch_assoc($hasil)) {
                echo "<tr class='table-row'>";
                echo "<td scope='row'>";
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
                echo htmlspecialchars($baris['tugas']);
                echo "</td>";

                echo "<td scope='row'>";
                echo $baris['status'];
                echo "</td>";

                echo "<td>";
                echo "<a href='start.php?id=" . $baris['id'] . "' class='btn btn-primary'>Start</a> ";
                echo "<a href='delete.php?id=" . $baris['id'] . "' class='btn btn-danger delete'>Delete</a> ";

                echo "<td>";
                echo "<input type='checkbox' name='task_done' onchange='this.form.submit()' " . ($baris['status'] == 'Done' ? 'checked' : '') . ($baris['status'] == 'No Status' ? 'disabled' : '') . ">";
                echo "<input type='hidden' name='id' value='" . $baris['id'] . "'>";
                echo "</td>";
                echo "</tr>";
                $delay += 200;
              }
              mysqli_free_result($hasil);
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="script/script.js"></script>
    <script>    var urlString = window.location.href;
      var url = new URL(urlString);
      var id = url.searchParams.get("id");
      document.getElementById("id").value = id;

      var tugas = url.searchParams.get("tugas");
      document.getElementById("tugas").value = tugas;

      var status = url.searchParams.get("status");
      document.getElementById("status").value = status;

      var priority = url.searchParams.get("priority");

      if (priority == 1) {
        priority = "Low";
      } else if (priority == 2) {
        priority = "Medium";
      } else {
        priority = "High";
      }
      document.getElementById("priority").value = priority;</script>

    <script>
      const deleteButtons = document.querySelectorAll('.delete');
      deleteButtons.forEach(button => {
        button.addEventListener('click', function (event) {
          const confirmation = confirm('Apakah Anda yakin ingin menghapus item ini?');
          if (!confirmation) {
            event.preventDefault();
          }
        });
      });
    </script>
</body>

</html>

<?php
mysqli_close($koneksi);
?>