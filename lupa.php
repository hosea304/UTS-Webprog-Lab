<?php session_start() ?>
<!DOCTYPE html>
<html>

<head>
  <title>Lupa Password</title>
</head>

<body>
  <h2>Lupa Password</h2>
  <form action="proses/lupa_password.php" method="post">
    <label for="username">Username:</label><br>
    <input type="text" id="username" name="username"><br>
    <label for="new_password">Password Baru:</label><br>
    <input type="password" id="new_password" name="new_password"><br>
    <label for="confirm_password">Konfirmasi Password Baru:</label><br>
    <input type="password" id="confirm_password" name="confirm_password"><br>
    <input type="submit" value="Ubah Password">
    <?php if (isset($_SESSION['error'])) {
      echo "<p>" . $_SESSION['error'] . "</p>";
      unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
      echo "<p>" . $_SESSION['success'] . "</p>";
      unset($_SESSION['success']);
    } ?>
  </form>
</body>

</html>