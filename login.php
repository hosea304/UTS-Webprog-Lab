<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        .custom-form-control:hover,
        .custom-form-control:focus {
            border-color: #4CAF50;
        }

        .custom-button {
            transition: transform 0.2s;
        }

        .custom-button:hover {
            background-color: #4CAF50;
            transform: scale(1.02);
        }

        .custom-alert {
            animation: fadeIn 0.5s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
    <title>Login</title>
</head>

<body class="text-white justify-content-center" style="background-color: #C8E4B2;">
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color:white;">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item fs-4">
                        <a class="nav-link text-info " href="register.php">Register</a>
                    </li>
                    <li class="nav-item fs-4 me-3">
                        <a class="nav-link text-info" href="login.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
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
            <a href="lupa.php" class="text-info">Lupa Password?</a>
            <button type="submit"
                class="w-50 py-2 mx-auto mt-5 btn btn-primary rounded-3 custom-button fs-5">Login</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>