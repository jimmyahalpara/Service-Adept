<?php
    // prevent direct access to this file 
    include __DIR__ . '/../../Utilities/preventDirectAccess.php';


    class ServiceModel {
        // database connection
        private $conn;
        // table name
        private $table_name = "Service";

        // object properties
        public $id;
        public $service_name;
        public $description;
        public $price_type_id;
        public $price;
        public $city;
        public $organization_id;
        public $category_id;


        // constructor with $db as database connection
        public function __construct($db) {
            $this->conn = $db;
        }

        
        // function to read services from table
        public function read(){
            // select all query
            $query = "SELECT * FROM " . $this->table_name;

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // execute query
            $stmt -> execute();
            
            $result = $stmt -> fetchAll(PDO::FETCH_ASSOC);

            return $result;
        }

        // function for creating new service
        public function create(){
            // query to insert record
            $query = "INSERT INTO
                        " . $this->table_name . ' (service_name, description, price_type_id, price, city, organization_id, category_id) values (:service_name, :description, :price_type_id, :price, :city, :organization_id, :category_id)';

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this->service_name=htmlspecialchars(strip_tags($this->service_name));
            $this->description=htmlspecialchars(strip_tags($this->description));
            $this->price_type_id=htmlspecialchars(strip_tags($this->price_type_id));
            $this->price=htmlspecialchars(strip_tags($this->price));
            $this->city=htmlspecialchars(strip_tags($this->city));
            $this->organization_id=htmlspecialchars(strip_tags($this->organization_id));
            $this->category_id=htmlspecialchars(strip_tags($this->category_id));

            // bind values
            $stmt->bindParam(":service_name", $this->service_name);
            $stmt->bindParam(":description", $this->description);
            $stmt->bindParam(":price_type_id", $this->price_type_id);
            $stmt->bindParam(":price", $this->price);
            $stmt->bindParam(":city", $this->city);
            $stmt->bindParam(":organization_id", $this->organization_id);
            $stmt->bindParam(":category_id", $this->category_id);

            // execute query
            if($stmt->execute()){
                // assign new id 
                $this->id = $this->conn->lastInsertId();
                return true;
            }

            return false;
        }

    }


?>