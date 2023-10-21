<?php
session_start();
$koneksi = mysqli_connect("localhost", "root", "", "todo");

if (mysqli_connect_errno()) {
    die("Koneksi database gagal: " . mysqli_connect_error() . "(" . mysqli_connect_errno() . ")");
}

// Retrieve user_id from the session
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if ($user_id === null) {
    die("User ID not found in the session.");
}

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $tugas = $_POST['tugas'];
    $priority = $_POST['priority'];
    $status = $_POST['status'];

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
  $status = mysqli_escape_string($koneksi, $status);

  $sqlEdit = "UPDATE tbl_tugas SET tugas ='" . $tugas . "', priority = '" . $priority . "', status = '" . $status . "' WHERE id = " . $id . " AND created_by_user_id = " . $user_id;
  mysqli_query($koneksi, $sqlEdit);

  header("Location: ../todo.php");
}

$sql = "SELECT * FROM tbl_tugas WHERE created_by_user_id = $user_id ORDER BY FIELD(status, 'On Progress', 'Done', 'No Status'), priority DESC";
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
      <div class="rounded-3 p-2" style=" box-shadow: 5px 5px 5px #888888; background-color: #FFF2D8">
      <div class="container text-center">
        <label>New To Do</label>
        <input type="hidden" name="id" id="id" required style="border: 1px solid #ccc; border-radius: 5px; padding: 3px; width: 20%; transition: border-color 0.3s, box-shadow 0.3s;"
        onmouseover="this.style.borderColor = '#007bff'; this.style.boxShadow = '0 0 5px #007bff';"
        onmouseout="this.style.borderColor = '#ccc'; this.style.boxShadow = 'none';">
        <input type="text" name="tugas" id="tugas" required style="border: 1px solid #ccc; border-radius: 5px; padding: 3px; width: 20%; transition: border-color 0.3s, box-shadow 0.3s;"
          onmouseover="this.style.borderColor = '#007bff'; this.style.boxShadow = '0 0 5px #007bff';"
          onmouseout="this.style.borderColor = '#ccc'; this.style.boxShadow = 'none';">
          <select name="priority" id="priority" style="border-radius: 5px;">
          <option value="High">High</option>
          <option value="Medium">Medium</option>
          <option value="Low">Low</option>
        </select>
        <select name="status" id="status" style="border-radius: 5px;">
          <option value="No Status">No Status</option>
          <option value="On Progress">On Progress</option>
          <option value="Done">Done</option>
        </select>
        <input type="submit" value="Save" class="Add rounded-3" name="submit">
</div>
      </form>
</div>

<div class="rounded-3 p-3" style=" box-shadow: 5px 5px 5px #888888; background-color: #FFF2D8">
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
                echo $baris['tugas'];
                echo "</td>";

                echo "<td scope='row'>";
                echo $baris['status'];
                echo "</td>";

                echo "<td>";
                echo "<a href='start.php?id=" . $baris['id'] . "' class='btn btn-primary'>Start</a> ";
                echo "<a href='delete.php?id=" . $baris['id'] . "' class='btn btn-danger delete'>Delete</a> ";
                echo "</td>";

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
            </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../script/script.js"></script>
    <script>
      var urlString = window.location.href;
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
      document.getElementById("priority").value = priority;
    </script>

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