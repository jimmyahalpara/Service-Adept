<?php 
    require_once __DIR__ . '/../../Utilities/preventDirectAccess.php';
    
    require_once __DIR__ . '/../User/UserModel.php';
    require_once __DIR__ . '/../Organization/OrganizationModel.php';

    class ProviderModel{
        // database connection 
        private $conn;
        // table name
        private $table_name = "provider";


        // object properties
        public $id;
        public $user_id;
        public $organization_id;

        // constructor with $db as database connection
        public function __construct($db){
            $this->conn = $db;
        }

        // function to read Provider from the table
        function read(){
            // query to select all records from table
            $query = "SELECT * FROM " . $this->table_name;

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // execute query
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }


        // function for creating new Provider
        function create(){
            
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
                // set new id inserted
                $this->id = $this->conn->lastInsertId();

                // set access level to 2 for user with user_id
                $user = new UserModel($this->conn);
                $user -> id = $this->user_id;
                $user -> readOne();
                $user -> access_level = 2;
                $user -> update();
                return true;
            }

            return false;
        }


        // function for updating Provider
        function update(){
            // query to update record
            $query = "UPDATE " . $this->table_name . " SET user_id=:user_id, organization_id=:organization_id WHERE id=:id";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this->user_id=htmlspecialchars(strip_tags($this->user_id));
            $this->organization_id=htmlspecialchars(strip_tags($this->organization_id));

            // bind values
            $stmt->bindParam(":user_id", $this->user_id);
            $stmt->bindParam(":organization_id", $this->organization_id);
            $stmt->bindParam(":id", $this->id);

            // execute query
            if ($stmt->execute()){
                return true;
            }

            return false;
        }

        // function for deleting Provider
        function delete(){
            // query to delete record
            $query = "DELETE FROM " . $this->table_name . " WHERE user_id=:id";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this->user_id=htmlspecialchars(strip_tags($this->user_id));

            // prepare query
            $stmt = $this->conn->prepare($query);

            // bind id of record to delete
            $stmt->bindParam(":id", $this->user_id);

            // execute query
            if ($stmt->execute()){
                // decrease access level of user with user_id
                $user = new UserModel($this->conn);
                $user -> id = $this->user_id;
                $user -> readOne();
                $user -> access_level = 1;
                $user -> update();
                return true;
            }
            
            return false;

        }

        // function for reading one Provider
        function readOne(){
            // query to read single record
            $query = "SELECT * FROM " . $this->table_name . " WHERE user_id=:id";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this->user_id=htmlspecialchars(strip_tags($this->user_id));

            // bind id of record to delete
            $stmt->bindParam(":id", $this->user_id);

            $stmt -> execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // set values to object properties
            $this->user_id = $row['user_id'];
            $this->organization_id = $row['organization_id'];
        }

        // function to readAll for organization_id 
        function readAllByOrganizationId(){
            // query to read all records from table
            $query = "SELECT * FROM " . $this->table_name . " WHERE organization_id=:id";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this->organization_id=htmlspecialchars(strip_tags($this->organization_id));

            // bind id of record to delete
            $stmt->bindParam(":id", $this->organization_id);

            $stmt -> execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

        // function for reading one Provider using id attribute 
        function readOneById(){
            // query to read single
            $query = "SELECT * FROM " . $this->table_name . " WHERE id=:id";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this -> id = htmlspecialchars(strip_tags($this -> id));

            // bind id of record to delete
            $stmt->bindParam(":id", $this->id);

            // execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // set values to object properties
            $this->user_id = $row['user_id'];
            $this->organization_id = $row['organization_id'];

        
        }

        // check if id exists in table
        function isIdPresent(){
            // query to read single
            $query = "SELECT * FROM " . $this->table_name . " WHERE id=:id";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this -> id = htmlspecialchars(strip_tags($this -> id ));

            // bind values
            $stmt -> bindParam(":id", $this -> id);

            // execute query
            $stmt -> execute();
            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            if ($row){
                return true;
            } else {
                return false;
            }
        }

        // check if user_id exists in table
        function isUserIdPresent(){
            // query to read single
            $query = "SELECT * FROM " . $this->table_name . " WHERE user_id=:user_id";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this -> user_id = htmlspecialchars($this -> user_id);

            // bind values
            $stmt -> bindParam(":user_id", $this -> user_id);

            // execute query
            $stmt -> execute();

            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            if ($row){
                return true;
            } else {
                return false;
            }
        }

        // get userModel from user_id
        function getUserModel(){
            $user = new UserModel($this->conn);
            $user -> id = $this -> user_id;
            $user -> readOne();
            return $user;
        }

        // get organizationModel from organization_id
        function getOrganizationModel(){
            $organization = new OrganizationModel($this->conn);
            $organization -> id = $this -> organization_id;
            $organization -> readOne();
            return $organization;
        }
    }
?>