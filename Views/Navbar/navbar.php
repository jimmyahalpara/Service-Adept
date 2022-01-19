
<style>
    <?php 
        require_once __DIR__ . '/navbar.css';
    ?>
</style>

<nav>
    <h1 id="navbar_heading">Service Adept</h1>
    <?php
        if (isset($_SESSION['user_id'])) {
            echo "<span id='welcome_text'>Welcome ". $_SESSION['name']."</span>";
            echo '<a class="buttonLink" href="logout.php">Logout</a>';
        } else {
            echo '<a class="buttonLink" href="login.php">Login</a>';
        }
    ?>
</nav>