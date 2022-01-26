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
        if (isset($_POST['service_id']) && isset($_POST['provider_id'])) {
            // create ServiceProvider model 
            $serviceProviderModel = new ServiceProviderModel($pdo);
            $serviceProviderModel->service_id = $_POST['service_id'];
            $serviceProviderModel->provider_id = $_POST['provider_id'];

            
            try {
                $serviceProviderModel->create();
            } catch (Exception $e) {
                setUserCreationError($e->errorInfo[2]. "(Tip: make sure that you dont have a duplicate entry)");
                return;
            }

            // redirect to manageServices
            header("Location: /service_adept/manageServices.php");

        }
    }
?>
