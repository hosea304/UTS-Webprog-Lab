<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Lupa Password</title>
  <!-- Add Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Add your custom styles -->
  <style>
    body {
      background-color: #f8f9fa;
      padding: 20px;
    }

    h2 {
      color: #007bff;
    }

    form {
      max-width: 400px;
      margin: 0 auto;
    }

    .error-message {
      color: #dc3545;
    }

    .success-message {
      color: #28a745;
    }
  </style>
</head>

<body>
  <div class="container">
    <h2 class="mt-4">Lupa Password</h2>
    <form action="proses/lupa_password.php" method="post">
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" class="form-control" id="username" name="username">
      </div>
      <div class="form-group">
        <label for="new_password">Password Baru:</label>
        <input type="password" class="form-control" id="new_password" name="new_password">
      </div>
      <div class="form-group">
        <label for="confirm_password">Konfirmasi Password Baru:</label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password">
      </div>
      <button type="submit" class="btn btn-primary">Ubah Password</button>

      <?php if (isset($_SESSION['error'])): ?>
        <p class="error-message"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
      <?php endif; ?>

      <?php if (isset($_SESSION['success'])): ?>
        <p class="success-message"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
      <?php endif; ?>
    </form>
  </div>

  <!-- Add Bootstrap JS and Popper.js -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
