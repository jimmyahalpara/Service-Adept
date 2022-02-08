<?php 

    session_start();
    define('LOADER', true);
    require_once __DIR__ . "/../Utilities/importAllModels.php";
    require_once __DIR__ . "/../database/configuration.php";
    loginAccessRequired(3);

    
    if (isset($_POST['id'])){
        if (!empty($_FILES['imageFile']['name'])){
            $fileName = basename($_FILES['imageFile']['name']);
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

        

            $allowTypes = array('jpg', 'jpeg', 'gif', 'png');
            if (in_array($fileType, $allowTypes)) {
                $image = $_FILES['imageFile']['tmp_name'];
                // $stmt = $pdo->prepare("INSERT INTO `images` (`img_name`, `img_data`) VALUES (?,?)");
                // $stmt->execute([$_FILES["file"]["name"], file_get_contents($_FILES["file"]["tmp_name"])]);

                // $id = $pdo -> lastInsertId();
                // echo 'To view Image : <a href="imageView.php?id='.$id.'">Go Here</a><br>
                // To download Image: <a href="getImage.php?id='.$id.'">Go Here</a>';
                


                // query to update image column in Service table 
                $query = "UPDATE `service` SET `image` = ? WHERE `id` = ?";
                $fileData = file_get_contents($image);
                $params = [$fileData, $_POST['id']];
                $result = executeQuery($pdo, $query, $params);
                echo "DONE";

            }
        }
    }


?>
