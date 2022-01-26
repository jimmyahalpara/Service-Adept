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
        if (isset($_POST['service_provider_id'])) {
            // check if there are any ServiceOrder for ServiceProvider 
            $serviceOrderModel = new ServiceOrderModel($pdo);
            $serviceOrderModel->service_provider_id = $_POST['service_provider_id'];

            // create query to select orders which are not complete and with the same service provider
            $query = "SELECT * FROM serviceorder WHERE service_provider_id = :service_provider_id AND completed != 1";
            $params = array(
                ":service_provider_id" => $serviceOrderModel->service_provider_id
            );

            $result = executeQuery($pdo,$query, $params);
            var_dump(count($result));
            if (count($result) > 0) {
                setUserCreationError("You cannot delete this service provider because there are service orders associated with it.");
                return;
            }

            // create ServiceProvider model 
            $serviceProviderModel = new ServiceProviderModel($pdo);
            $serviceProviderModel->id = $_POST['service_provider_id'];

            
            
            try {
                $serviceProviderModel->delete();
            } catch (Exception $e) {
                setUserCreationError($e->errorInfo[2]. "(Tip: You cannot delete a provider if there is an order associated with it)");
                return;
            }

            // redirect to manageServices
            header("Location: /service_adept/manageServices.php");

        }
    }
?>
