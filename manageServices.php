<?php
    define("LOADER", true);
    session_start();
    // import all models
    require_once __DIR__ . "/Utilities/importAllModels.php";
    // require database connection
    require_once __DIR__ . "/database/configuration.php";
    // login required
    loginAccessRequired(3);
?>
<!DOCTYPE html>
<html lang="en">
<?php
        require_once __DIR__ . "/Views/Header/header.php" 
?>
<body>
    


<?php
    define("CURRENT_PAGE", "Organization");
    require_once __DIR__ . '/Views/Navbar/navbar.php';

    


    if ($_SESSION['access_level'] == 4){
        // get organization id
        $admin = new OrganizationAdminModel($pdo);
        $admin -> user_id = $_SESSION['user_id'];
        $admin -> readOne();
        $organization_id = $admin -> organization_id;
    } else if ($_SESSION['access_level'] == 3) {
        $manager = new OrganizationManagerModel($pdo);
        $manager -> user_id = $_SESSION['user_id'];
        $manager -> readOne();
        $organization_id = $manager -> organization_id;
    } else if ($_SESSION['access_level'] == 2) {
        $provider = new ProviderModel($pdo);
        $provider -> user_id = $_SESSION['user_id'];
        $provider -> readOne();
        $organization_id = $provider -> organization_id;
    }

    // read_all Services by organization_id
    $service = new ServiceModel($pdo);
    $service -> organization_id = $organization_id;
    
    $services = $service -> readAllByOrganizationId();
    $categoryModel = new CategoryModel($pdo);
    $categories = $categoryModel->read();

    // get all pricetypes 
    $priceTypeModel = new PriceTypeModel($pdo);
    $priceTypes = $priceTypeModel->getAllPriceTypes();

    // get all cities
    $cityModel = new CityModel($pdo);
    $cities = $cityModel->read();

    // all providers in organization
    $providerModel = new ProviderModel($pdo);
    $providerModel -> organization_id = $organization_id;
    $providers = $providerModel->readAllByOrganizationId();

    // execute custom query to join Provider and User table to get all providers for organization
    $query = "SELECT provider.id as provider_id, user.username as username FROM provider INNER JOIN User ON provider.user_id = user.id WHERE provider.organization_id = :organization_id";
    $params = [
        ':organization_id' => $organization_id
    ];
    $providers = executeQuery($pdo, $query, $params);
    // var_dump($providers);
    require_once __DIR__ . '/Views/ManageService/manageServiceView.php';
?>


</body>
</html>