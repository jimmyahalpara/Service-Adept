<?php
    // redirect users to index page if they try to access this page directly
    include __DIR__ . '/../../Utilities/preventDirectAccess.php';

    class OrganizationModel {
        // database connection
        private $conn;
        // table name
        private $table_name = "organization";

        // object properties
        public $id;
        public $name;

        // constructor with $db as database connection
        public function __construct($db) {
            $this->conn = $db;
        }

        // function to read organization from table
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

        // function for creating new organization
        public function create(){
            // query to insert record
            $query = "INSERT INTO
                        " . $this->table_name . ' (name) values (:name)';

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this->name=htmlspecialchars(strip_tags($this->name));

            // bind values
            $stmt->bindParam(":name", $this->name);

            // execute query
            if($stmt->execute()){
                // assign new id 
                $this->id = $this->conn->lastInsertId();
                return true;
            }

            return false;
        }

        // function for updating organization
        public function update(){
            // query to update record
            $query = "UPDATE " . $this->table_name . " SET name = :name WHERE id = :id";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->id=htmlspecialchars(strip_tags($this->id));

            // bind values
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":id", $this->id);

            // execute query
            if($stmt->execute()){
                return true;
            }

            return false;
        }

        // function for deleting organization
        public function delete(){
            // query to delete record
            $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this->id=htmlspecialchars(strip_tags($this->id));

            // bind id of record to delete
            $stmt->bindParam(1, $this->id);

            // execute query
            if($stmt->execute()){
                return true;
            }

            return false;
        }

        // function to readONe organization
        public function readOne(){
            // query to read single record
            $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this->id=htmlspecialchars(strip_tags($this->id));

            // bind id of record to read
            $stmt->bindParam(1, $this->id);

            // execute query
            $stmt->execute();

            // get retrieved row
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // set values to object properties
            $this->name = $row['name'];
        }


        // function to check if ID is present in Organization   
        public function isIdPresent(){
            // query to read single record
            $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this->id=htmlspecialchars(strip_tags($this->id));

            // bind id of record to read
            $stmt->bindParam(1, $this->id);

            // execute query
            $stmt->execute();

            // get retrieved row
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            
            // check if id is present
            if($row){
                return true;
            }

            return false;
        }
    }

?>