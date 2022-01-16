<?php
require_once "../../database/pdo.php";

session_start();

if (isset($_POST['cancel'])) {
    // Redirect the browser to home.php
    header("Location: ../Home/home.php");
    return;
}
if (isset($_POST['signup'])) {
    // Redirect the browser to home.php
    header("Location: ../Signup/signup.php");
    return;
}


// Check to see if we have some POST data, if we do process it
if (isset($_POST['email']) && isset($_POST['password'])) {
    unset($_SESSION['email']);     // Logout current user
    if (strlen($_POST['email']) < 1 || strlen($_POST['password']) < 1) {
        $_SESSION['error'] = "User name and password are required";
        header('Location: login.php');
        return;
    } else {
        // $_email = $_POST['email'];
        // $_password = $_POST['password'];


        // if ($row !== false) {

        //     $_SESSION['name'] = $row['name'];

        //     $_SESSION['user_id'] = $row['user_id'];


        //     header("Location: home.php");

        //     return;
        // } else {
        //     $_SESSION['error'] = "Incorrect password";
        //     header('Location: login.php');
        //     return;
        // }
    }
} ?>


<?php require_once "../Header/header.php" ?>
<style>
    <?php require_once "./login.css" ?>
</style>

<body>

    <div class="mainContainer">

        <div class="text">
            <h1 class="bigText"> Log-in </h1>
            <p class="smallText">Get access to resources that <br>will help you to get <br>your services.</p>
        </div>

        <form method="POST">
            <div class="inputs">
                <input name="email" id="email" class="email" type="email" placeholder="E-mail">
                <br>
                <input name="password" id="password" class="password" type="password" placeholder="Password">
            </div>

            <button name="login" type="submit" onclick="return dovalidate()" class="login">Log-in</button>
            <div class="hr">
                <hr>
            </div>

            <div class="socialIcons">
                <button class="socialLogos"><i class="fa fa-facebook-f"></i></button>
                <button class="socialLogos"><i class="fa fa-google"></i></button>
            </div>
            <p class="bottomText">Don't have an account?</p>
            <form action="POST">

                <p class="signup"> <input type="submit" name="signup" value="signup">
                </p>
            </form>

        </form>


    </div>
    <div class="square">

        <img src="../../images/Saly-12.svg" class="mobileImg">
    </div>


</body>

<script src="../../Scripts/middleware.js"></script>