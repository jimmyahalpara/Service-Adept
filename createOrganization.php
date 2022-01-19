<?php
// define LOADER to true
session_start();
define('LOADER', true);

// include all models
require_once __DIR__ . '/Utilities/importAllModels.php';

// include $pdo from database config 
require_once __DIR__ . '/database/configuration.php';

function createOrganizationError($message)
{
    $_SESSION['createOrganizationError'] = $message;
    header("Location: " . $_SERVER["PHP_SELF"]);
}

// var_dump($_POST);
if (isset($_POST['submit'])) {
    if (isset($_POST['name']) && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password_1']) && isset($_POST['password_2']) && isset($_POST['phone']) && isset($_POST['address']) && isset($_POST['city']) && isset($_POST['gender']) && isset($_POST['organization_name']) && (strlen($_POST['name']) > 0) && (strlen($_POST['username']) > 0) && (strlen($_POST['email']) > 0) && (strlen($_POST['password_1']) > 0) && (strlen($_POST['password_2']) > 0) && (strlen($_POST['name']) > 0) && (strlen($_POST['phone']) > 0) && (strlen($_POST['address']) > 0) && (strlen($_POST['city']) > 0)) {
        $name = $_POST['name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password_1 = $_POST['password_1'];
        $password_2 = $_POST['password_2'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $gender = $_POST['gender'];
        $organization_name = $_POST['organization_name'];

        // check if passwords are equal 
        if ($password_1 == $password_2) {
            // verify if email is valid or not 
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // verify if username is valid or not 
                if (preg_match("/^[a-zA-Z0-9]*$/", $username)) {
                    $user = new UserModel($pdo);
                    $user->username = $username;

                    // check if username is present or not 
                    if (!$user->isUsernamePresent()) {
                        $user->email = $email;
                        if (!$user->isEmailPresent()) {
                            $user->name = $name;
                            $user->password = UserModel::hashPassword($password_1);
                            $user->phone = $phone;
                            $user->address = $address;
                            $user->city = $city;
                            // echo "<br>GENDER ".$gender;
                            $user->gender = $gender;
                            $user->access_level = 4;
                            // create user
                            $user->create();

                            $new_user_id = $user->id;

                            // create organization
                            $organization = new OrganizationModel($pdo);
                            $organization->name = $organization_name;
                            $organization->create();

                            // create organization_admin
                            $organization_admin = new OrganizationAdminModel($pdo);
                            $organization_admin->user_id = $new_user_id;
                            $organization_admin->organization_id = $organization->id;
                            $organization_admin->create();

                            // redirect to login page
                            header("Location: " . dirname($_SERVER["PHP_SELF"]).'/login.php');
                        } else {
                            createOrganizationError("Email already exists");
                            return;
                        }
                    } else {
                        createOrganizationError("Username already exists");
                        return;
                    }
                } else {
                    createOrganizationError("Username should not have any space or special characters");
                }
            } else {
                createOrganizationError("Invalid Email");
            }
        } else {
            createOrganizationError("Passwords do not match");
        }
    } else {
        createOrganizationError("All Fields are required");
        return;
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<?php
require_once __DIR__ . "/Views/CreateOrganizationView/createOrganizationView.php";
?>

</html>