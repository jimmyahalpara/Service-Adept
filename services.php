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


    require_once __DIR__ . '/Views/Navbar/navbar.php';

    require_once __DIR__ . '/Views/Service/ServiceView.php';
?>


</body>
</html>