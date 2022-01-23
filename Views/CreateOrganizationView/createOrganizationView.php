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
            <p style="color:red" >
                <?php 
                    if(isset($_SESSION['createOrganizationError'])){
                        echo $_SESSION['createOrganizationError'];
                        unset($_SESSION['createOrganizationError']);
                    }
                ?>
            </p>
            <h1 id="createOrganizationHeading">Create Organization</h1>
            <p>User Who is currently logged in, will be admin of this organization, if you dont want that, then logout and change user first, and then comeback to this page</p>
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