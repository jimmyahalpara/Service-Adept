<?php
    session_start();
    define('LOADER', true);
    require_once __DIR__ . "/../Utilities/importAllModels.php";
    require_once __DIR__ . "/../database/configuration.php";
    loginAccessRequired(3);


    function setUserCreationError($message)
    {
        $_SESSION['Error'] = $message;
        header("Location: /service_adept/manageServices.php");
    }
    var_dump($_POST);
    if (isset($_POST['submit']) && isset($_SESSION['access_level']) && ($_SESSION['access_level'] == 3 || $_SESSION['access_level'] == 4)) {
        if (isset($_POST['visibility'])) {

            

            // query to change visibility of service 
            $service = new ServiceModel($pdo);
            // instead of creating new input tage for service_id, we passed it in submit button
            $service -> id = $_POST['submit'];
            $service -> visibility = $_POST['visibility'];
            $service -> updateVisibility();
            header("Location: /service_adept/manageServices.php");
            return;

        }
    }
?>
