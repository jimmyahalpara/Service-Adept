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
    if (isset($_POST['submit'])){
        if (isset($_POST['name']) && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['address']) && isset($_POST['city']) && isset($_POST['gender'])){

            $name = $_POST['name'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $city = $_POST['city'];
            $gender = $_POST['gender'];

            // checking if email is valid
            if (strlen($name) == 0 || strlen($username) == 0 || strlen($email) == 0 || strlen($phone) == 0 || strlen($address) == 0 || strlen($city) == 0 || strlen($gender) == 0){
                setUserUpdateError("All Fields are required");
                return;
            }


            if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                setUserUpdateError("Invalid Email");
                return;
            }

            $user = new UserModel($pdo);
            // check if username already exists
            $user -> id = $_SESSION['user_id'];
            $user -> readOne();
            $user -> email = $email;
            $user -> username = $username;
            $user -> name = $name;
            $user -> email = $email;
            // hash the password
            $user -> phone = $phone;
            $user -> address = $address;
            $user -> city_id = $city;
            $user -> gender = $gender;
            try {
                $user -> update();
                header("Location: /service_adept/userMyaccount.php");
                return;
            } catch (Exception $e) {
                setUserUpdateError("Error updating user: ". $e->errorInfo[2]);
                return;
            }   
            
            

        } else {
            setUserUpdateError("All Fields are required");
            return;
        }
    }
    

?>