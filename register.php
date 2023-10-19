<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Register</title>
</head>

<body class="bg-dark text-white justify-content-center">
    <?php include('navigation.php') ?>
    <h1 class="text-center my-5">Register</h1>
    <div class="w-25 mx-auto">
        <form action="proses/register_proses.php" method="post" class="d-flex flex-column fs-5">
            <label for="username" class="px-2 form-label">Username</label>
            <input type="text" name="username" class="px-2 py-2 form-control">
            <br>
            <label for="pass" class="px-2 form-label">Password</label>
            <input type="password" name="pass" class="px-2 py-2 form-control">
            <br>
            <label for="confirm" class="px-2 form-label">Confirm Password</label>
            <input type="password" name="confirm" class="px-2 py-2 form-control mb-4">
            <?php
            if (isset($_GET['error']) && $_GET['error'] == 1) {
                echo "<div class='alert alert-danger text-center mb-4'>Mohon isi semua data yang diperlukan</div>";
            } elseif (isset($_GET['error']) && $_GET['error'] == 2) {
                echo "<div class='alert alert-danger text-center mb-4'>Password tidak sesuai</div>";
            }
            ?>
            <button type="submit" class="w-25 py-2 mx-auto mt-5 btn btn-success rounded-3">Register</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>