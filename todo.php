<?php
session_start();
$koneksi = mysqli_connect("localhost", "root", "", "todo");

if (mysqli_connect_errno()) {
    die("Koneksi database gagal: " . mysqli_connect_error() . "(" . mysqli_connect_errno() . ")");
}

if (isset($_POST['submit'])) {
    $tugas = $_POST['listBaru'];
    $priority = $_POST['priority'];
    $tanggal = $_POST['tanggal'];
    $deskripsi = $_POST['deskripsi'];
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    if ($user_id === null) {
        die("User ID not found in the session.");
    }

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

    $tugas = mysqli_real_escape_string($koneksi, $tugas);
    $priority = mysqli_real_escape_string($koneksi, $priority);
    $tanggal = mysqli_real_escape_string($koneksi, $tanggal); 
    $deskripsi = mysqli_real_escape_string($koneksi, $deskripsi);

    // Using prepared statement to prevent SQL injection
    $stmt = $koneksi->prepare("INSERT INTO tbl_tugas (user_id, priority, tugas, tanggal, deskripsi, status) VALUES (?, ?, ?, ?, ?, 'No Status')");
   
    $stmt->bind_param("iisss", $user_id, $priority, $tugas, $tanggal, $deskripsi);
    $stmt->execute();
    $stmt->close();

    // Redirect after form submission
    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}

if (isset($_POST['task_done'])) {
    $id = $_POST['id'];
    $isChecked = $_POST['task_done'] ? 1 : 0;

    $status = $isChecked ? 'Done' : 'On Progress';

    $sql = "UPDATE tbl_tugas SET status = '$status' WHERE id = $id";
    mysqli_query($koneksi, $sql);

    // Redirect after form submission
    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if ($user_id === null) {
    die("User ID not found in the session.");
}

$sql = "SELECT * FROM tbl_tugas WHERE user_id = $user_id ORDER BY FIELD(status, 'On Progress', 'Done', 'No Status'), priority DESC";
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="script/style.css">
</head>

<body>
<?php include('navigation.php') ?>
  <div class="container-fluid">
    <div class='d-flex justify-content-center align-items-center w-100 h-100 flex-column'>
      <h1 class="mb-3">To-do list</h1>
      <form action="todo.php" method='POST' class="mb-3">
      <div class="rounded-3 p-3" style=" box-shadow: 5px 5px 5px #888888; background-color: #FFF2D8">
        <label>New To Do</label>
        <input type="text" name="listBaru" id="listBaru" required style="border: 1px solid #ccc; border-radius: 5px; padding: 3px; width: 20%; transition: border-color 0.3s, box-shadow 0.3s; border-color: #ccc; box-shadow: none;"
        onmouseover="this.style.borderColor = '#007bff'; this.style.boxShadow = '0 0 5px #007bff';"
        onmouseout="this.style.borderColor = '#ccc'; this.style.boxShadow = 'none';">
        <label>Tanggal</label>
        <input type="date" name="tanggal" id="tanggal" required style="border: 1px solid #ccc; border-radius: 5px; padding: 3px; width: 20%; transition: border-color 0.3s, box-shadow 0.3s;">
        <label>Deskripsi</label>
        <input type="text" name="deskripsi" id="deskripsi" required style="border: 1px solid #ccc; border-radius: 5px; padding: 3px; width: 20%; transition: border-color 0.3s, box-shadow 0.3s; border-color: #ccc; box-shadow: none;"
        onmouseover="this.style.borderColor = '#007bff'; this.style.boxShadow = '0 0 5px #007bff';"
        onmouseout="this.style.borderColor = '#ccc'; this.style.boxShadow = 'none';">
        <select name="priority" id="option" style="border-radius: 5px;">
        <option value="High">High</option>
        <option value="Medium">Medium</option>
        <option value="Low">Low</option>
      </select>
      <div class="text-center">
  <input type="submit" value="Add" class="Add rounded-3" name="submit">
</div>

      </form>
</div>
      
<div class="rounded-3 p-3" style=" box-shadow: 5px 5px 5px #888888; background-color: #FFF2D8">
      <div class="table-container">
        <table class="table scrollable-table">
          <thead class="table-primary">
            <tr>
              <th scope="col">Priority</th>
              <th scope="col">Task</th>
              <th scope="col">Progress</th>
              <th scope="col">Tanggal</th>
              <th scope="col">Deskripsi</th>
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

              echo "<td scope='row'>";
              echo $baris['tanggal'];
              echo "</td>";

              echo "<td scope='row'>";
              echo $baris['deskripsi'];
              echo "</td>";

              echo "<td>";
              echo "<a href='update/start.php?id=" . $baris['id'] . "' class='btn btn-primary'>Start</a> ";
              echo "<a href='update/edit.php?id=" . $baris['id'] . "&tugas=" . $baris['tugas'] . "&status=" . $baris['status'] . "&priority=" . $baris['priority'] . "' class='btn btn-warning'>Edit</a> ";
              echo "<a href='update/delete.php?id=" . $baris['id'] . "' class='btn btn-danger delete'>Delete</a> ";
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
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="script/script.js"></script>
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
<?php
mysqli_close($koneksi);
?>