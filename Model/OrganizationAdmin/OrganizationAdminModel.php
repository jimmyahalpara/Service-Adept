<?php

    // prevent users from directly loading this page
    include __DIR__ . '/../../Utilities/preventDirectAccess.php';
    

    // include UserModel.php
    include __DIR__ . '/../User/UserModel.php';

    // include OrganizationModel.php
    include __DIR__ . '/../Organization/OrganizationModel.php';

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
                // store new id 
                $this->id = $this->conn->lastInsertId();
                return true;
            }

            return false;
            
        }

        // function for deleting OrganizationAdmin
        public function delete(){
            // query to delete record
            $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this->id=htmlspecialchars(strip_tags($this->id));

            // bind values
            $stmt->bindParam(":id", $this->id);

            // execute query
            if($stmt->execute()){
                // check if user_id is exist in UserModel
                $userModel = new UserModel($this->conn);
                $userModel -> id = $this -> user_id;
                if ($userModel -> isIdPresent()){
                    // read one record from UserModel
                    $userModel -> readOne();
                    // Decrease access level of user to OrganizationAdmin
                    $userModel -> access_level = 1;
                    $userModel -> update();
                }
                return true;
            }

            return false;
        }

        // function to get OrganizationAdmin UserModel
        public function getUserModel(){
            // check if user_id is exist in UserModel
            $userModel = new UserModel($this->conn);
            $userModel -> id = $this -> user_id;
            if (!$userModel -> isIdPresent()){
                return false;
            }

            // read one record from UserModel
            $userModel -> readOne();
            return $userModel;
        }

        // function to get OrganizationModel for OrganizationAdmin
        public function getOrganizationModel(){
            // check if organization_id is exist in OrganizationModel
            $organizationModel = new OrganizationModel($this->conn);
            $organizationModel -> id = $this -> organization_id;
            if (!$organizationModel -> isIdPresent()){
                return false;
            }

            // read one record from OrganizationModel
            $organizationModel -> readOne();
            return $organizationModel;
        }

        // function to check if User_id is present in OrganizationAdmin
        public function isIdPresent(){
            // query to read single record
            $query = "SELECT id FROM " . $this->table_name . " WHERE user_id = :user_id";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this->user_id=htmlspecialchars(strip_tags($this->user_id));

            // bind values
            $stmt->bindParam(":user_id", $this->user_id);

            // execute query
            $stmt->execute();

            // get retrieved row
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row){
                return true;
            } else {
                return false;
            }
        }

        // function to readOne with particular user_id
        public function readOne(){
            // query to read single record
            $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = :user_id";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this->user_id=htmlspecialchars(strip_tags($this->user_id));

            // bind values
            $stmt->bindParam(":user_id", $this->user_id);

            // execute query
            $stmt->execute();

            // get retrieved row
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // set values to object properties
            $this->id = $row['id'];
            $this->user_id = $row['user_id'];
            $this->organization_id = $row['organization_id'];
        }

        


    }


?>