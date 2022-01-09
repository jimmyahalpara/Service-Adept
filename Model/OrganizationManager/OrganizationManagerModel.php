<?php
    // prevent direct access to this file using preventDirectAccess.php
    include __DIR__ . '/../../Utilities/preventDirectAccess.php';

    // include UserModel.php and OrganizationModelAdmin.php
    // include_once __DIR__ . '/../User/UserModel.php';
    include __DIR__ . '/../OrganizationAdmin/OrganizationAdminModel.php';



    class OrganizationManagerModel{
        // database connection 
        private $conn;
        // table name
        private $table_name = "OrganizationManager";


        // object properties
        public $id;
        public $user_id;
        public $organization_id;

        // constructor with $db as database connection
        public function __construct($db){
            $this->conn = $db;
        }

        // function to read OrganizationManager from the table
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


        // function for creating new OrganizationManager
        public function create(){
            // check if user_id is exist in UserModel
            $userModel = new UserModel($this->conn);
            $userModel -> id = $this -> user_id;
            if (!$userModel -> isIdPresent()){
                // var_dump("HERE");
                return false;
            }

            

            // check if user_id is present in OrganizationAdmin
            $organizationAdminModel = new OrganizationAdminModel($this->conn);
            $organizationAdminModel -> user_id = $this -> user_id;
            $organizationAdminModel -> organization_id = $this -> organization_id;
            if ($organizationAdminModel -> isIdPresent()){
                return false;
            }


            // read one record from UserModel
            $userModel -> readOne();
            // Increase access level of user to OrganizationManager
            $userModel -> access_level = 3;
            $userModel -> update();

            // query to insert record
            $query = "INSERT INTO " . $this->table_name . ' (user_id, organization_id) values (:user_id,:organization_id)';

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this->user_id=htmlspecialchars(strip_tags($this->user_id));
            $this->organization_id=htmlspecialchars(strip_tags($this->organization_id));

            // bind values
            $stmt->bindParam(":user_id", $this->user_id);
            $stmt->bindParam(":organization_id", $this->organization_id);
            
            // execute query
            if ($stmt->execute()){
                return true;
            }

            return false;
            
        }

        // function to update OrganizationManager
        public function update(){
            // query to update record
            $query = "UPDATE " . $this->table_name . " SET user_id=:user_id, organization_id=:organization_id WHERE id=:id";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this->id=htmlspecialchars(strip_tags($this->id));
            $this->user_id=htmlspecialchars(strip_tags($this->user_id));
            $this->organization_id=htmlspecialchars(strip_tags($this->organization_id));

            // bind values
            $stmt->bindParam(":id", $this->id);
            $stmt->bindParam(":user_id", $this->user_id);
            $stmt->bindParam(":organization_id", $this->organization_id);

            // execute query
            if ($stmt->execute()){
                return true;
            }

            return false;
        } 

        // function for deleting OrganizationManager
        public function delete(){
            // query to delete record
            $query = "DELETE FROM " . $this->table_name . " WHERE user_id = ?";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this->user_id=htmlspecialchars(strip_tags($this->user_id));

            // bind id of record to delete
            $stmt->bindParam(1, $this->user_id);

            // execute query
            if ($stmt->execute()){
                // reduce user access level to 1
                $userModel = new UserModel($this->conn);
                $userModel -> id = $this -> user_id;
                $userModel -> readOne();
                $userModel -> access_level = 1;
                $userModel -> update();


                return true;
            }

            return false;
        }

        // function to readOne with partirular user_id
        public function readOne(){
            // query to read one record
            $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = ?";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this->user_id=htmlspecialchars(strip_tags($this->user_id));

            // bind id of record to read
            $stmt->bindParam(1, $this->user_id);

            // execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // set values to object properties
            $this -> id = $row['id'];
            $this->user_id = $row['user_id'];
            $this->organization_id = $row['organization_id'];
        }

        // function to get UserModel 
        public function getUserModel(){
            $userModel = new UserModel($this->conn);
            $userModel -> id = $this -> user_id;
            if (!$userModel -> isIdPresent()){
                return false;
            }

            // read one record from UserModel
            $userModel -> readOne();
            return $userModel;
        }

        // function to get OrganizationModel from ORganizationManagerModel
        public function getOrganizationModel(){
            $organizationModel = new OrganizationModel($this->conn);
            $organizationModel -> id = $this -> organization_id;
            if (!$organizationModel -> isIdPresent()){
                return false;
            }

            // read one record from OrganizationModel
            $organizationModel -> readOne();
            return $organizationModel;
        }


    }


?>