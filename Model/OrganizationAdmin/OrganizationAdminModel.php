<?php

    // prevent users from directly loading this page
    include __DIR__ . '/../../Utilities/preventDirectAccess.php';
    

    // include UserModel.php
    include __DIR__ . '/../User/UserModel.php';


    class OrganizationAdminModel{
        // database connection and table
        // database connection
        private $conn;
        // table name
        private $table_name = "OrganizationAdmin";


        // object properties
        public $id;
        public $user_id;
        public $organization_id;

        // constructor with $db as database connection
        public function __construct($db){
            $this->conn = $db;
        }

        // function to read OrganizationAdmin from the table 
        public function read(){
            // select all query
            $query = "SELECT * FROM " . $this->table_name;

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // execute query
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }


        // function for creating new OrganizationAdmin
        public function create(){
            // check if user_id is exist in UserModel
            $userModel = new UserModel($this->conn);
            $userModel -> id = $this -> user_id;
            if (!$userModel -> isIdPresent()){
                return false;
            }

            // read one record from UserModel
            $userModel -> readOne();
            // Increase access level of user to OrganizationAdmin
            $userModel -> access_level = 4;
            $userModel -> update();

            // query to insert record
            $query = "INSERT INTO
                        " . $this->table_name . ' (user_id, organization_id) values (:user_id,:organization_id)';
            
            // sanitize username
            $this -> user_id = htmlspecialchars(strip_tags($this -> user_id));
            $this -> organization_id = htmlspecialchars(strip_tags($this -> organization_id));

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // bind values
            $stmt->bindParam(":user_id", $this->user_id);
            $stmt->bindParam(":organization_id", $this->organization_id);

            // execute query
            if ($stmt->execute()){
                return true;
            }

            return false;
            
        }

    }


?>