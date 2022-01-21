<style>
    <?php
    require_once __DIR__ . '/navbar.css';
    define("CURRENT_PAGE", 'home');
    ?>
</style>

<nav class="navbar navbar-expand-lg navbar-dark">
    <a href="#" class="navbar-brand mx-3">Service-Adept</a>
    <button class="btn navbar-toggler"><span class="navbar-toggler-icon" data-toggle="collapse" data-target="#navbarCollapsing"></span></button>
    <div class="collapse navbar-collapse" id="navbarCollapsing">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item <?php if (constant('CURRENT_PAGE') == 'home') {
                                    echo "active";
                                } ?>"><a href="/" class="nav-link">Home</a></li>
            <li class="nav-item"><a href="#" class="nav-link">User</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Services</a></li>

            <?php
            if (isset($_SESSION['name'])) {
                echo '<li class="nav-item">
                    <div class="dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                            ' . $_SESSION['name'] . '
                        </a>
    
                        <div class="dropdown-menu">
                            <a href="#" class="dropdown-item">My Account</a>
                            <a href="#" class="dropdown-item">My Cart</a>
                            <div class="dropdown-divider"></div>
                            <a href="logout.php" class="dropdown-item">Logout</a>
                        </div>
                    </div>
                </li>';
            } else {
                echo '<li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>';
            }
            ?>


        </ul>
    </div>
</nav>