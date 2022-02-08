<?php 
    session_start();
    define('LOADER', true);
    require_once __DIR__ . "/../Utilities/importAllModels.php";
    require_once __DIR__ . "/../database/configuration.php";
    loginAccessRequired(1);

    if (!isset($_GET['id'])) {
        die("No Id specified");
    }


    // $stmt = $pdo->prepare("SELECT  FROM `images` WHERE `id`=?");
    // $stmt->execute([htmlspecialchars(strip_tags($_GET['id']))]);
    // $imgR = $stmt->fetch();
    // $img = $imgR["img_data"];

    // query to get image data from Service table
    $query = "SELECT `image` FROM `service` WHERE `id`=?";
    $params = [htmlspecialchars(strip_tags($_GET['id']))];
    $result = executeQuery($pdo, $query, $params);

    if (count($result) == 0) {
        die("No image found");
    }

    $img = $result[0]["image"];



    header("Content-type: image/jpeg");
    echo $img;

?>