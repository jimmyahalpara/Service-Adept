<?php
    // prevent direct access by including preventDirectAccess.php
    include __DIR__ . '/../../Utilities/preventDirectAccess.php';

    // include UserModel.php
    // include __DIR__ . '/../User/UserModel.php';


    class CustomerCareExecutiveModel {
        // database connection 
        private $conn;
        // table name
        private $table_name = "CustomerCareExecutive";


        // object properties
        public $id;
        public $user_id;
        public $care_count;

        // constructor with $db as database connection
        public function __construct($db){
            $this->conn = $db;
        }

        // function to read CustomerCareExecutive from the table
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


        // function for creating new CustomerCareExecutive
        public function create(){
            


            // insert query
            $query = "INSERT INTO " . $this->table_name . " (user_id, care_count) VALUES (:user_id, :care_count)";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this->user_id=htmlspecialchars(strip_tags($this->user_id));
            $this->care_count=htmlspecialchars(strip_tags($this->care_count));

            // bind values
            $stmt->bindParam(":user_id", $this->user_id);
            $stmt->bindParam(":care_count", $this->care_count);

            // execute query
            if ($stmt->execute()){
                // reduce access level of user to CustomerCareExecutive
                $userModel = new UserModel($this->conn);
                $userModel -> id = $this->user_id;
                $userModel -> readOne();
                $userModel -> access_level = 2;
                $userModel -> update();
                
                return true;
            }

            return false;
        }


        // function to increase care_count of CustomerCareExecutive
        public function increaseCareCount(){
            // update query
            $query = "UPDATE " . $this->table_name . " SET care_count = care_count + 1 WHERE user_id = :user_id";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this->user_id=htmlspecialchars(strip_tags($this->user_id));

            // bind values
            $stmt->bindParam(":user_id", $this->user_id);

            // execute query
            if ($stmt->execute()){
                return true;
            }

            return false;
        }


        // function to decrease care_count of CustomerCareExecutive
        public function decreaseCareCount(){
            // update query
            $query = "UPDATE " . $this->table_name . " SET care_count = care_count - 1 WHERE user_id = :user_id";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this->user_id=htmlspecialchars(strip_tags($this->user_id));

            // bind values
            $stmt->bindParam(":user_id", $this->user_id);

            // execute query
            if ($stmt->execute()){
                return true;
            }

            return false;
        }


        // function to delete CustomerCareExecutive
        public function delete(){
            // delete query
            $query = "DELETE FROM " . $this->table_name . " WHERE user_id = :user_id";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this->user_id=htmlspecialchars(strip_tags($this->user_id));

            // bind values
            $stmt->bindParam(":user_id", $this->user_id);

            // execute query
            if ($stmt->execute()){
                // reduce access level of user to User
                $userModel = new UserModel($this->conn);
                $userModel -> id = $this -> user_id;
                $userModel -> readOne();
                $userModel -> access_level = 1;
                $userModel -> update();
                return true;
            }

            return false;
        }


        // function to readOne() CustomerCareExecutive
        public function readOne(){
            // select query
            $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this->user_id=htmlspecialchars(strip_tags($this->user_id));

            // bind values
            $stmt->bindParam(":id", $this->id);

            // execute query
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // set values to object properties
            $this->id = $result['id'];
            $this->user_id = $result['user_id'];
            $this->care_count = $result['care_count'];
        }

        // get UserModel data for given CustomerCareExecutive user_id
        public function getUserModel(){
            $userModel = new UserModel($this->conn);
            $userModel -> id = $this -> user_id;
            $userModel -> readOne();
            return $userModel;
        }

        // to check if specified user_id is present 
        public function isUserIdPresent(){
            // select query
            $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = :user_id";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this->user_id=htmlspecialchars(strip_tags($this->user_id));

            // bind values
            $stmt->bindParam(":user_id", $this->user_id);

            // execute query
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result){
                return true;
            }

            return false;
        }

        // to check if specified id is present 
        public function isIdPresent(){
            // select query
            $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this->id=htmlspecialchars(strip_tags($this->id));

            // bind values
            $stmt->bindParam(":id", $this->id);

            // execute query
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result){
                return true;
            }

            return false;
        }


    }

?>