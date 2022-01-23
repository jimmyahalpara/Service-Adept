<?php 
    session_start();
    
    // import all models
    define('LOADER', true);
    require_once __DIR__ . "/../Utilities/importAllModels.php";
    require_once __DIR__ . "/../database/configuration.php";
    loginRequired();

    function setUserUpdateError($error){
        $_SESSION['userUpdateError'] = $error;
        header("Location: /service_adept/userMyaccount.php");
    }
    var_dump($_POST);
    if (isset($_POST['submit'])){
        if (isset($_POST['password_old']) && isset($_POST['password1']) && isset($_POST['password2'])){

            $old_password = $_POST['password_old'];
            $new_password1 = $_POST['password1'];
            $new_password2 = $_POST['password2'];

            $user = new UserModel($pdo);
            $user->id = $_SESSION['user_id'];
            $user -> readOne();

            if (UserModel::hashPassword($old_password) == $user->password){
                if ($new_password1 == $new_password2){
                    $user->password = UserModel::hashPassword($new_password1);
                    $user->update();
                    header("Location: /service_adept/userMyaccount.php");
                    return;
                }
                else{
                    setUserUpdateError("New passwords do not match");
                    return;
                }
            }
            else{
                setUserUpdateError("Old password is incorrect");
                return;
            }

            
            

        } else {
            setUserUpdateError("All Fields are required");
            return;
        }
    }
    

?>