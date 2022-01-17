<?php

?>
<?php require_once "../Header/header.php" ?>
<style>
    <?php require_once "./signup.css" ?>
</style>

<body>
    <div class="mainContainer">

        <div class="text">
            <h1 class="bigText"> Sign up</h1>
        </div>

        <form method="POST">
            <div class="inputs">
                <input name="name" class="Name" type="Name" placeholder="Enter your name" required>
                <br>
                <input name="email" class="email" type="email" placeholder="Enter your e-mail Id" required>
                <br>
                <input name="pNumber" class="Number" type="phone number" placeholder="Enter your number" required>
                <br>
                <input name="password" class="password" type="password" placeholder="Enter your password" required>
            </div>

            <button class="signup">Sign up</button>
            <div class="hr">
                <hr>
            </div>

            <div class="socialIcons">
                <button class="socialLogos"><i class="fa fa-facebook-f"></i></button>
                <button class="socialLogos"><i class="fa fa-google"></i></button>
            </div>



            <p class="bottomText">Already have an account?</p>
            <p class="login"><a href="../login/Login.html" target="_blank">Log-in</a></p>

        </form>


    </div>
    <div class="square">

        <img src="../images/Saly-1.svg" class="Rocket">
    </div>


</body>