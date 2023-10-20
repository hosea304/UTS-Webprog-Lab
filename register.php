<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        .custom-form-control {
            /* Gaya umum untuk form control */
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .custom-form-control:hover,
        .custom-form-control:focus {
        border-color: #4CAF50; 
        }

        .custom-button {
            transition: transform 0.2s; 
        }

        .custom-button:hover {
            background-color: #4CAF50; 
            transform: scale(1.1); 
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
    <title>Register</title>
</head>

<body class="bg-dark text-white justify-content-center">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item fs-4">
                            <a class="nav-link" href="register.php">Register</a>
                        </li>
                        <li class="nav-item fs-4">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>  
    <h1 class="text-center my-5">Register</h1>
    <div class="w-25 mx-auto">
        <form action="proses/register_proses.php" method="post" class="d-flex flex-column fs-5">
            <label for="username" class="px-2 form-label">Username</label>
            <input type="text" name="username" class="px-2 py-2 form-control custom-form-control">
            <br>
            <label for="pass" class="px-2 form-label">Password</label>
            <input type="password" name="pass" class="px-2 py-2 form-control custom-form-control">
            <br>
            <label for="confirm" class="px-2 form-label">Confirm Password</label>
            <input type="password" name="confirm" class="px-2 py-2 form-control custom-form-control mb-4">
            <?php
            if (isset($_GET['error']) && $_GET['error'] == 1) {
                echo "<div class='alert alert-danger text-center mb-4 custom-alert'>Mohon isi semua data yang diperlukan</div>";
            } elseif (isset($_GET['error']) && $_GET['error'] == 2) {
                echo "<div class='alert alert-danger text-center mb-4 custom-alert'>Password tidak sesuai</div>";
            }
            ?>
            <button type="submit" class="w-25 py-2 mx-auto mt-5 btn btn-success rounded-3 custom-button">Register</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
