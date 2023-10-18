<?php
session_start();
session_destroy();
function function_alert($message) {
    echo "<script>alert('$message');</script>";
}

function_alert("Anda telah logout");

header('Location: ../login.php');
exit();
