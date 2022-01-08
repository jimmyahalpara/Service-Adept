<?php
    // prevent direct access by including preventDirectAccess.php
    include __DIR__ . '/../../Utilities/preventDirectAccess.php';

    // include UserModel.php
    include __DIR__ . '/../User/UserModel.php';


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
            // check if user_id is exist in UserModel
            $userModel = new UserModel($this->conn);
            $userModel -> id = $this -> user_id;
            if (!$userModel -> isIdPresent()){
                // var_dump("HERE");
                return false;
            }

            
            // check if user_id is present in CustomerCareExecutive
            $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = :user_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":user_id", $this->user_id);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (count($result) > 0){
                // var_dump("HERE");
                return false;
            }

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
                $userModel -> access_level = 2;
                $userModel -> update();
                
                return true;
            }

            return false;
        }
    }

?>