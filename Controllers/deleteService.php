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
        if (isset($_POST['service_id'])) {
            // check if service has and serviceProviders 
            $serviceProviderModel = new ServiceProviderModel($pdo);
            $serviceProviderModel->service_id = $_POST['service_id'];
            $res = $serviceProviderModel -> readAllByService();
            if (count($res)){
                setUserCreationError("Remove all Service Providers before deleting the Service");
                return;
            } 
            // read serviceModel with service_id 
            $service = new ServiceModel($pdo);
            $service->id = $_POST['service_id'];
            
            try {
                $service->delete();
            } catch (Exception $e) {
                setUserCreationError($e->errorInfo[2]);
                return;
            }

            // redirect to manageServices
            header("Location: /service_adept/manageServices.php");

        }
    }
?>
