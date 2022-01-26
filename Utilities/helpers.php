<?php
    function loginRequired(){
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['username']) || !isset($_SESSION['email']) || !isset($_SESSION['name']) || !isset($_SESSION['access_level'])){
            header('Location: /service_adept/login.php');
            exit();
        }
    }

    function loginAccessRequired($level){
        loginRequired();
        if ($_SESSION['access_level'] < $level){
            header('Location: /service_adept/');
            exit();
        }
    }

    // function to create and execute custom sql query
    function executeQuery($pdo, $query, $params){
        $stmt = $pdo->prepare($query);
        $stmt-> execute($params);

        // get result 
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

?>