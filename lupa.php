<?php session_start() ?>
<!DOCTYPE html>
<html>

<head>
  <title>Lupa Password</title>
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
  <h1 class="text-center my-5">Lupa Password</h1>
  <div class="w-25 mx-auto">
    <form action="proses/lupa_password.php" method="post" class="d-flex flex-column fs-5">
      <label for="username" class="px-2 form-label">Username:</label><br>
      <input type="text" id="username" name="username" class="px-2 py-2 form-control custom-form-control"><br>
      <label for="new_password" class="px-2 form-label">Password Baru:</label><br>
      <input type="password" id="new_password" name="new_password"
        class="px-2 py-2 form-control custom-form-control"><br>
      <label for="confirm_password" class="px-2 form-label">Konfirmasi Password Baru:</label><br>
      <input type="password" id="confirm_password" name="confirm_password"
        class="px-2 py-2 form-control custom-form-control"><br>
      <?php if (isset($_SESSION['error'])) {
        echo "<p class='bg-danger mx-2 text-center '>" . $_SESSION['error'] . "</p>";
        unset($_SESSION['error']);
      } ?>
      <input type="submit" value="Ubah Password"
        class="w-50 py-2 mx-auto mt-3 btn btn-primary rounded-3 custom-button fs-5">
    </form>
  </div>
</body>

</html>