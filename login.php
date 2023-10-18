<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('bootstrap.php') ?>
    <title>Login</title>
</head>

<body class=" bg-dark text-white justify-content-center">
    <?php include('navigation.php') ?>
    <h1 class="text-center my-5">Login</h1>
    <div class="w-25 mx-auto">
        <form action="proses/login_proses.php" method="post" class="d-flex flex-column fs-5">
            <label for="username" class="px-2 form-label">Username</label>
            <input type="text" name="username" class="px-2 py-2 form-control custom-form-control">
            <br>
            <label for="pass" class="px-2 form-label">Password</label>
            <input type="password" name="pass" class="px-2 py-2 form-control custom-form-control">
            <br>
            <?php
            if (isset($_GET['not%found'])) {
                echo "<div class='alert alert-danger text-center mb-4 custom-alert'>User tidak ditemukan</div>";
            } else if (isset($_GET['wrong%pass'])) {
                echo "<div class='alert alert-danger text-center mb-4 custom-alert'>Password salah</div>";
            }
            ?>
            <button type="submit" class="w-25 py-2 mx-auto mt-5 btn btn-primary rounded-3 custom-button">Login</button>
        </form>
    </div>
</body>

</html>