<?php
    // echo "<pre>";
    // define LOADER to true
    define("LOADER", true);
    session_start();
    // import all models
    require_once __DIR__ . "/Utilities/importAllModels.php";

    // require database connection
    require_once __DIR__ . "/database/configuration.php";


    function setLoginError($message)
    {
        $_SESSION['loginError'] = $message;
        header("Location: " . $_SERVER['PHP_SELF']);
    }

    // var_dump($_POST);
    if (isset($_POST['submit'])){
        if (isset($_POST['email']) && isset($_POST['password'])){
            // validate email
            $email = $_POST['email'];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                setLoginError("Invalid Email");
                return;
            }
            // validate password
            $password = $_POST['password'];
            if (strlen($password) == 0){
                setLoginError("Password is required");
                return;
            }

            $user = new UserModel($pdo);
            $user -> email = $email;
            
            if ($user -> isEmailPresent()){
                $hashedPassword = UserModel::hashPassword($password);
                $user -> readOneUsingEmail();
                if ($user -> password === $hashedPassword){
                    $_SESSION['user_id'] = $user -> id;
                    $_SESSION['username'] = $user -> username;
                    $_SESSION['email'] = $user -> email;
                    $_SESSION['name'] = $user -> name;
                    $_SESSION['access_level'] = $user -> access_level;

                    
                    header("Location: " . dirname($_SERVER['PHP_SELF']). "/userDetail.php");
                    return;
                } else {
                    setLoginError("Invalid Password");
                    return;
                }
            } else {
                setLoginError("Invalid Email");
                return;
            }

        } else {
            setLoginError("All Fields are required");
            return;
        }
    }

    // echo "</pre>"


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');



        form,
        h1,
        input,
        textarea,
        select,
        p {
            font-family: 'Roboto', sans-serif;
        }



        input,
        label,
        textarea,
        select {
            font-size: 1.25em;
            margin: 5px 10px;
        }

        input,
        textarea {
            width: 500px;
        }

        button {
            font-size: 1.25em;
            margin: 5px 10px;
            width: 150px;
        }

        input:focus:required:invalid {
            content: "*";
            outline: 3px solid red;
            border-color: transparent;
        }

        div.loginContainer {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 80vh;
            /* border: 1px solid black; */

        }

        #login_heading_id {
            text-align: center;
        }

        table, td, tr {
            /* outline: 1px solid black; */
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="loginContainer">
        <form method="POST">
            <table>
                <tr>
                    <td colspan="2">
                        <h1 id="login_heading_id">Login</h1>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <?php
                        if (isset($_SESSION['loginError'])) {
                            echo "<p style='color:red;'>" . $_SESSION['loginError'] . "</p>";
                            unset($_SESSION['loginError']);
                        }
                        
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><label for="input_email">Enter Email: </label></td>
                    <td><input type="email" name="email" id="input_email" required></td>
                </tr>
                <tr>
                    <td><label for="input_password">Enter Password: </label></td>
                    <td><input type="password" name="password" id="input_password" required></td>
                </tr>
                <tr>
                    <td colspan="2"><button type="submit" name="submit">Submit</button></td>
                </tr>
            </table>
        </form>

    </div>
</body>

</html>