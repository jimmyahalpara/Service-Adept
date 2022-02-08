<?php
    define("LOADER", true);
    session_start();
    // import all models
    require_once __DIR__ . "/Utilities/importAllModels.php";
    // login required
    loginRequired();
    // require database connection
    require_once __DIR__ . "/database/configuration.php";
?>
<!DOCTYPE html>
<html lang="en">
<?php
        require_once __DIR__ . "/Views/Header/header.php" 
?>
<body>
    

<?php
    define("CURRENT_PAGE", "Services");
    
    $categoryModel = new CategoryModel($pdo);
    $categories = $categoryModel->read();


    $priceTypeModel = new PriceTypeModel($pdo);
    $priceTypes = $priceTypeModel->getAllPriceTypes();

    $cityModel = new CityModel($pdo);
    $cities = $cityModel->read();


    $serviceModel = new ServiceModel($pdo);
    $services = $serviceModel->read();
    // we'll update this later incase filter is applied to the services
    // var_dump($services);

    // service Category 
    $serviceCategoryModel = new CategoryModel($pdo);
    $serviceCategories = $serviceCategoryModel->read();

    // read all cities 
    $cityModel = new CityModel($pdo);
    $cities = $cityModel->read();


    // current user object 
    $userModel = new UserModel($pdo);
    $userModel -> id = $_SESSION['user_id'];
    $userModel->readOne();


    // read all price types
    $priceTypeModel = new PriceTypeModel($pdo);
    $priceTypes = $priceTypeModel->getAllPriceTypes();
    
    require_once __DIR__ . '/Views/Navbar/navbar.php';

    require_once __DIR__ . '/Views/Service/ServiceView.php';
?>


</body>
</html>