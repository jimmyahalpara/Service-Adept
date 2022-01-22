<?php
    require_once __DIR__.'/../Header/header.php';
    require_once __DIR__.'/../../Utilities/preventDirectAccess.php';
?>

    <style>
        <?php
            require_once __DIR__. '/createOrganizationView.css'; 
        ?>
    </style>
<body>
    <div class="formContainer">
        <form class="DetailForm" method="POST">
            <h1>Create User</h1>
            <p style="color:red" >
                <?php 
                    if(isset($_SESSION['createOrganizationError'])){
                        echo $_SESSION['createOrganizationError'];
                        unset($_SESSION['createOrganizationError']);
                    }
                ?>
            </p>
            <table>
                <tr>
                    
                    <td>
                        <input type="text" name="name" id="input_name" placeholder="Firstname Lastname" maxlength="64" required>
                    </td>
                </tr>
                <tr>
                    
                    <td>
                        <input type="text" name="username" id="input_username" placeholder="Enter Username" title="Should not have any space or special characters" pattern="\w*" maxlength="64" required>
                    </td>
                </tr>
                <tr>
                    
                    <td>
                        <input type="email" name="email" id="input_email" placeholder = "Enter Email Id" maxlength="64" required>
                    </td>
                </tr>
                <tr>
                    <td><input type="password" name="password_1" id="input_password_1" onkeyup="password_1_keyup()" placeholder="Enter password" required></td>
                </tr>
                <tr>
                    <td><input type="password" name="password_2" id="input_password_2" onkeyup="password_2_keyup()" placeholder="Reenter password" required></td>
                </tr>
                <tr>
                    <td><input type="tel" name="phone" id="input_phone" pattern="\d{10}" title="Enter 10 digits of phone number" placeholder="Enter Phone Number" required></td>
                </tr>
                <tr>
                    <td><textarea name="address" id="input_address" cols="30" rows="10" maxlength="195" title="Address Required" placeholder="Enter Address" required></textarea></td>
                </tr>
                <tr>
                    <td><select name="city" id="input_city">
                    <?php
                        $city = new CityModel($pdo);
                        $result = $city -> read();
                        foreach ($result as $row){
                            echo "<option value='".$row['id']."'>".$row['name']."</option>";
                        }
                    ?>
                </select><br></td>
                </tr>
                <tr>
                    <td><select name="gender" id="input_gender">
                        <option value="0">Female</option>
                        <option value="1">Male</option>
                        <option value="2" selected>Gender Prefer Not to Tell</option>
                    </select></td>
                </tr>
            </table>
            <h1 id="createOrganizationHeading">Create Organization</h1>
            <p>The User with above detail will be the first admin of your Organization</p>
            <table>
                <tr>
                    
                    <td><input type="text" name="organization_name" maxlength="128" id="input_organization_name" placeholder="Enter Organization name"></td>
                </tr>
                <tr>
                    <td>
                        <button type="submit" id="submitButton" name="submit" value="submit">Submit</button>
                    </td>
                </tr>
            </table>
    </form>

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
</body>