<?php 
    // prevent direct access
    require_once __DIR__ . '/../../Utilities/preventDirectAccess.php';
    // require_once __DIR__. "/../Header/header.php"

?>


    <div class="mainContainer">

        <div class="text">
            <h1 class="bigText"> Log-in </h1>
            <p class="smallText">Get access to resources that <br>will help you to get <br>your services.</p>
        </div>

        <form action="login.php" id="loginForm" method="POST">
            <div class="inputs">
                <?php 
                    if (isset($_SESSION["loginError"])){
                        echo "<span>".$_SESSION['loginError']."<span>";
                    }

                ?>
                <input class="email d-block" type="email" placeholder="E-mail" name="email">
                <br>
                <input class="password d-block" type="password" placeholder="Password" name="password">
            </div>
            
            <button type="submit" name="submit" value="submit" class="login">Log-in</button>
            <div  class="hr">
                <hr>
            </div>
        </form>

            <div class="socialIcons">
                <button type="button" class="socialLogos"><i class="fa fa-facebook-f"></i></button>
                <button type="button" class="socialLogos"><i class="fa fa-google"></i></button>
            </div>
            <p class="bottomText">Don't have an account?</p>
            <p class="signup"><a href="Signup.html" target="_blank">Sign up</a></p>



    </div>
    <div class="square">

        <img src="./Pages/images/Log-in-3D-Doodle.svg" class="mobileImg">
    </div>
    <script>
        $("#loginForm").validate({
            rules: {
                email: "required",
                password: "required"
            },
            messages: {
                email: "You need to enter valid email",
                password: "Please Enter password"
            }
        });
    </script>



