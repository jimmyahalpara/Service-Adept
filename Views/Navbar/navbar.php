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
            <?php
                if (isset($_SESSION['user_id'])){
                    echo '<li class="nav-item"><a href="#" class="nav-link">Services</a></li>';
                    if ($_SESSION['access_level'] == 1){
                        echo '<li class="nav-item"><a href="createOrganization.php" class="nav-link">Create Organization</a></li>';
                    } else if ($_SESSION['access_level'] >= 2 && $_SESSION['access_level'] <= 4){
                        echo '<li class="nav-item">
                        <div class="dropleft">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                                Manage Organization
                            </a><div class="dropdown-menu">';
                        if ($_SESSION['access_level'] == 3 || $_SESSION['access_level'] == 4){
                            echo '<a href="#" class="dropdown-item">Services</a>';
                            echo '<a href="#" class="dropdown-item">Providers</a>';
                            
                        }
                        if ($_SESSION['access_level'] == 4){
                            echo '<a href="#" class="dropdown-item">Managers</a>';
                            echo '<a href="#" class="dropdown-item">Admins</a>';
                        }
                        echo '<a href="#" class="dropdown-item">Orders</a>
                            </div>
                            </div>
                            </li>';
                        
                    }
                
                } 

            ?>
            <?php
            if (isset($_SESSION['name'])) {
                echo '<li class="nav-item">
                    <div class="dropleft">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                            ' . $_SESSION['name'] . '
                        </a>
    
                        <div class="dropdown-menu">
                            <a href="#" class="dropdown-item">My Account</a>
                            <a href="#" class="dropdown-item">My Cart</a>
                            <a href="#" class="dropdown-item">Payments</a>
                            <div class="dropdown-divider"></div>
                            <a href="logout.php" class="dropdown-item">Logout</a>
                        </div>
                    </div>
                </li>';
            } else {
                echo '<li class="nav-item"><a href="login.php" class="nav-link mx-1 loginsignup text-white">Login</a></li>';
                echo '<li class="nav-item"><a href="createUser.php" class="nav-link mx-1 loginsignup text-white">Sign Up</a></li>';
            }
            ?>

            
        </ul>
    </div>
</nav>