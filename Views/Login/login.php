<?php 
    // prevent direct access
    require_once __DIR__ . '/../../Utilities/preventDirectAccess.php';
    require_once __DIR__. "/../Header/header.php"

?>
<style>
    <?php require_once __DIR__. "./login.css" ?>
</style>

<body>

    <div class="mainContainer">

        <div class="text">
            <h1 class="bigText"> Log-in </h1>
            <p class="smallText">Get access to resources that will help you to get your services.</p>
            <p style="color:red;">
                <?php
                    if (isset($_SESSION['loginError'])){
                        echo $_SESSION['loginError'];
                        unset($_SESSION['loginError']);
                    }
                ?>
            </p>
        </div>

        <form method="POST" autocomplete="on">
            <div class="inputs">
                <input name="email" id="email" class="email" type="email" placeholder="E-mail" required>
                <br>
                <input name="password" id="password" class="password" type="password" placeholder="Password" required>
            </div>

            <button name="submit" type="submit" onclick="return dovalidate()" class="login">Log-in</button>
        </form>
            <div class="hr">
                <hr>
            </div>

            <div class="socialIcons">
                <button class="socialLogos"><i class="fa fa-facebook-f"></i></button>
                <button class="socialLogos"><i class="fa fa-google"></i></button>
            </div>
            <p class="bottomText">Don't have an account? <button id="loginSignUpButton" onclick="window.location='createUser.php'; return false;">SignUp</button></p>
            



    </div>
    <div class="square">

        <img src="Views/images/Saly-12.svg" class="mobileImg">
    </div>


</body>