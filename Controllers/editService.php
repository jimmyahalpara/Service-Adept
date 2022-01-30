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
        if (isset($_POST['service_name']) && isset($_POST['category_id']) && isset($_POST['pricetype']) && isset($_POST['city']) && isset($_POST['description']) && isset($_POST['price']) && isset($_POST['service_id'])) {

            

            $service_name = $_POST['service_name'];
            $category_id = $_POST['category_id'];
            $pricetype = $_POST['pricetype'];
            $city = $_POST['city'];
            $description = $_POST['description'];
            $price = $_POST['price'];

            // check if price is numeric
            if (!is_numeric($price)) {
                setUserCreationError("Price must be a number.");
                return;
            }

            // checking if email is valid
            if (strlen($service_name) == 0 || strlen($category_id) == 0 || strlen($pricetype) == 0 || strlen($city) == 0 || strlen($description) == 0 || strlen($price) == 0) {
                setUserCreationError("All Fields are required");
                return;
            }

            // read serviceModel with service_id 
            $service = new ServiceModel($pdo);
            $service->id = $_POST['service_id'];
            $service->readOne();

            // update service
            $service->service_name = $service_name;
            $service->category_id = $category_id;
            $service->price_type_id = $pricetype;
            $service->city_id = $city;
            $service->description = $description;
            $service->price = $price;

            try {
                $service->update();
            } catch (Exception $e) {
                setUserCreationError($e->errorInfo[2]);
                return;
            }

            // redirect to manageServices
            header("Location: /service_adept/manageServices.php");

        }
    }
?>
