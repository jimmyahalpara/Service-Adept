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


?>