<nav class="navbar navbar-expand bg-white py-3 px-5">
    <div class="container justify-content-between">
        <div class="w-25">
            <?php
            if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
                ?>
                <div class="dropdown">
                    <a class="dropdown-toggle link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover rounded-3 fs-5"
                        href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        <?= $_SESSION['username'] ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuLink">
                        <a href="proses/logout_proses.php" class="dropdown-item">Logout</a>
                    </div>
                </div>
                <?php
            } else {
                ?>
                <a href="login.php"
                    class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover rounded-3 fs-5">Login</a>
                <span class="opacity-50 fs-5">|</span>
                <a href="register.php"
                    class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover rounded-3 fs-5">Register</a>
                <?php
            }
            ?>
        </div>
    </div>
</nav>