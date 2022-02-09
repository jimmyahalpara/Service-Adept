<?php
// define LOADER to true
session_start();
define('LOADER', true);

require_once __DIR__ . '/Utilities/importAllModels.php';

// include $pdo from database config 
require_once __DIR__ . '/database/configuration.php';
// include all models
loginRequired();

function createOrganizationError($message)
{
    $_SESSION['createOrganizationError'] = $message;
    header("Location: " . $_SERVER["PHP_SELF"]);
}


if (isset($_POST['submit'])) {
    if (isset($_POST['organization_name'])) {
        $user = new UserModel($pdo);
        $user->id = $_SESSION['user_id'];
        if (!$user->isIdPresent()) {
            createOrganizationError('User not found');
            return;
        }
        $user->readOne();
        if ($user->access_level != 1) {
            createOrganizationError('You are not allowed to create Organization');
            return;
        }





        


        // create organization
        $organization = new OrganizationModel($pdo);
        $organization->name = $_POST['organization_name'];
        $organization->create();
        

        // create organization_admin
        $organization_admin = new OrganizationAdminModel($pdo);
        $organization_admin->user_id = $user -> id;
        $organization_admin->organization_id = $organization->id;
        $organization_admin->create();

        // redirect to login page
        header("Location: " . dirname($_SERVER["PHP_SELF"]) . '/login.php');
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