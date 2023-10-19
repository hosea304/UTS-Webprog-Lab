<?php
$koneksi = mysqli_connect("localhost", "root", "", "todo");

if (mysqli_connect_errno()) {
    die("Koneksi database gagal: " . mysqli_connect_error() . "(" . mysqli_connect_errno() . ")");
}

if (
    !isset($_POST['username']) || empty($_POST['username']) ||
    !isset($_POST['pass']) || empty($_POST['pass']) ||
    !isset($_POST['confirm']) || empty($_POST['confirm'])
) {
    header('Location: ../register.php?error=1');
    exit();
} else {
    $username = $_POST['username'];
    $pass_tmp = $_POST['pass'];
    $confirm = $_POST['confirm'];
    if ($confirm == $pass_tmp) {
        $password = $pass_tmp;
    } else {
        header('Location: ../register.php?error=2');
        exit();
    }
}

// Check if the username already exists
$check_sql = "SELECT nama FROM user WHERE nama = ?";
$check_stmt = $koneksi->prepare($check_sql);

if (!$check_stmt) {
    die('Error in preparing the SQL statement: ' . $koneksi->error);
}

$check_stmt->bind_param("s", $username);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
    // Username already exists
    header('Location: ../register.php?error=3');
    exit();
}

$en_pass = password_hash($password, PASSWORD_BCRYPT);

$sql = "INSERT INTO user (nama, password) VALUES (?, ?)";
$stmt = $koneksi->prepare($sql);

if (!$stmt) {
    die('Error in preparing the SQL statement: ' . $koneksi->error);
}

$data = [$username, $en_pass];
$stmt->bind_param("ss", $data[0], $data[1]);

if (!$stmt->execute()) {
    die('Error in executing the SQL statement: ' . $stmt->error);
}

header('Location: ../login.php');
exit();
?>
