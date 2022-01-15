<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <link rel="stylesheet" href="createOrganizationView.css">
    <h1>Create User</h1>
    <form class="DetailForm">
        <table>
            <tr>
                <td>
                    <label for="input_name">Full Name: </label>
                </td>
                <td>
                    <input type="text" name="name" id="input_name" placeholder="Firstname Lastname" maxlength="64" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="input_username">Username: </label>
                </td>
                <td>
                    <input type="text" name="username" id="input_username" placeholder="Enter Username" title="Should not have any space or special characters" pattern="\w*" maxlength="64" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="input_email">Email ID: </label>
                </td>
                <td>
                    <input type="email" name="email" id="input_email" placeholder = "example@domain.com" maxlength="64" required>
                </td>
            </tr>
            <tr>
                <td><label for="input_password_1">Enter Password:</label></td>
                <td><input type="password" name="password_1" id="input_password_1" onkeyup="password_1_keyup()" required></td>
            </tr>
            <tr>
                <td><label for="input_password_2">Reenter password: </label></td>
                <td><input type="password" name="password_2" id="input_password_2" onkeyup="password_2_keyup()" required></td>
            </tr>
            <tr>
                <td><label for="input_phone">Enter Phone Numer: </label></td>
                <td><input type="tel" name="phone" id="input_phone" pattern="\d{10}" title="Enter 10 digits of phone number" required></td>
            </tr>
            <tr>
                <td><label for="input_address">Enter Address</label></td>
                <td><textarea name="address" id="input_address" cols="30" rows="10" maxlength="195" title="Address Required" required></textarea></td>
            </tr>
            <tr>
                <td><label for="input_city">City: </label></td>
                <td><input type="text" name="city" id="input_city" maxlength="256" required></td>
            </tr>
            <tr>
                <td><label for="input_gender">Gender: </label></td>
                <td><select name="gender" id="input_gender">
                    <option value="0">Female</option>
                    <option value="1">Male</option>
                    <option value="2">Prefer Not to Tell</option>
                </select></td>
            </tr>
        </table>
        <h1>Create Organization</h1>
        <p>The User with above detail will be the first admin of your Organization</p>
        <table>
            <tr>
                <td><label for="input_organization_name">Enter Organization Name: </label></td>
                <td><input type="text" name="organization_name" maxlength="128" id="input_organization_name"></td>
            </tr>
            <tr>
                <td>
                    <button type="submit">Submit</button>
                </td>
            </tr>
        </table>
    </form>
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
</html>