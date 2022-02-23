<?php
    // prevent direct access
    // require_once "../../Utilities/preventDirectAccess.php";
    require_once __DIR__. "/../Header/header.php" ?>
<style>
    <?php require_once __DIR__."./signup.css" ?>
</style>

    <div class="mainContainer">

        <div class="text">
            <h1 class="bigText"> Sign up</h1>
        </div>
        <p class="errormessage" style="color:red">
            <?php
                if (isset($_SESSION['createUserError'])){
                    echo $_SESSION['createUserError'];
                    unset($_SESSION['createUserError']);
                }
            ?>
        </p>
        <form method="POST" autocomplete="off">
            <div class="inputs">
                <input type="text" name="name" id="input_name" placeholder="Enter Full Name" maxlength="64" required><br>
                <input type="text" name="username" id="input_username" placeholder="Enter Username" title="Should not have any space or special characters" pattern="\w*" maxlength="64" required><br>
                <input type="email" name="email" id="input_email" placeholder = "Enter email id" maxlength="64" required> <br>
                <input type="password" name="password_1" id="input_password_1" onkeyup="password_1_keyup()" placeholder="Enter Password" required><br>
                <input type="password" name="password_2" id="input_password_2" onkeyup="password_2_keyup()" placeholder="Retype password" required><br>
                <input type="tel" name="phone" id="input_phone" pattern="\d{10}" title="Enter 10 digits of phone number" placeholder="Enter phone number" required><br>
                <textarea name="address" id="input_address" cols="30" rows="10" maxlength="195" title="Address Required" placeholder="Enter your address" required></textarea><br>
                <!-- <input type="text" name="city" id="input_city" maxlength="256" placeholder="Enter city" required><br> -->
                <select name="city" id="input_city">
                    <?php
                        $city = new CityModel($pdo);
                        $result = $city -> read();
                        foreach ($result as $row){
                            echo "<option value='".$row['id']."'>".$row['name']."</option>";
                        }
                    ?>
                </select><br>
                <select name="gender" id="input_gender">
                    <option value="0">Female</option>
                    <option value="1">Male</option>
                    <option value="2" selected>Gender- Prefer Not to Tell</option>
                </select>



            </div>
            <button type="submit" name="submit" value="submit" class="signup">Sign up</button>
        </form>
            <div class="hr">
                <hr>
            </div>

            <div class="socialIcons">
                <button class="socialLogos"><i class="fa fa-facebook-f"></i></button>
                <button class="socialLogos"><i class="fa fa-google"></i></button>
            </div>


            
            <p class="bottomText">Already have an account? <button class="login" onclick="window.location='login.php'; return false;">Login</button></p>
            



    </div>
    <div class="square">

        <img src="Views/images/Saly-1.svg" class="Rocket">
    </div>
    <script>
    let password_1 = document.getElementById("input_password_1");
    let password_2 = document.getElementById("input_password_2");

    function password_1_keyup() {
        let val = password_1.value;
        let strength = 0;
        if (val.length > 2){
            strength += 1;
        } 
        if (val.length > 5){
            strength += 1;
        }
        
        if (val.length > 10){
            strength += 1;
        }

        if (val.search(/\d/) !== -1){
            strength += 1;
        }

        if (val.search(/[\~\`\!\@\#\$\%\^\&\*\(\)\_\-\+\=\{\}\:\;\"\'\|\\\<\,\.\?\/]/) !== -1){
            strength += 1;
        }

        clrs = ["red", "#ff4800", "#ff7b00", "#c98a00", "#a2ab00", "#3bbf02"];

        password_1.style.outlineColor = clrs[strength];
    }

    function password_2_keyup() {
        if (password_1.value !== password_2.value){
            password_2.setCustomValidity("Passwords not same.");
        } else {
            password_2.setCustomValidity("");
        }
    }

</script>

