<?php
    // prevent direct access to this file 
    include __DIR__ . '/../../Utilities/preventDirectAccess.php';

    // include OrganizationModel.php 
    // include __DIR__ . '/../Organization/OrganizationModel.php';

    // include PriceTypeModel.php
    // include __DIR__ . '/../PriceType/PriceTypeModel.php';

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
        public $city_id;
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
                        " . $this->table_name . ' (service_name, description, price_type_id, price, city_id, organization_id, category_id) values (:service_name, :description, :price_type_id, :price, :city, :organization_id, :category_id)';

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this->service_name=htmlspecialchars(strip_tags($this->service_name));
            $this->description=htmlspecialchars(strip_tags($this->description));
            $this->price_type_id=htmlspecialchars(strip_tags($this->price_type_id));
            $this->price=htmlspecialchars(strip_tags($this->price));
            $this->city_id=htmlspecialchars(strip_tags($this->city_id));
            $this->organization_id=htmlspecialchars(strip_tags($this->organization_id));
            $this->category_id=htmlspecialchars(strip_tags($this->category_id));

            // bind values
            $stmt->bindParam(":service_name", $this->service_name);
            $stmt->bindParam(":description", $this->description);
            $stmt->bindParam(":price_type_id", $this->price_type_id);
            $stmt->bindParam(":price", $this->price);
            $stmt->bindParam(":city", $this->city_id);
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


        // function for updating service
        public function update(){
            // query to update record
            $query = "UPDATE " . $this->table_name . "
                        SET service_name = :service_name, description = :description, price_type_id = :price_type_id, price = :price, city_id = :city, organization_id = :organization_id, category_id = :category_id
                        WHERE id = :id";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this->service_name=htmlspecialchars(strip_tags($this->service_name));
            $this->description=htmlspecialchars(strip_tags($this->description));
            $this->price_type_id=htmlspecialchars(strip_tags($this->price_type_id));
            $this->price=htmlspecialchars(strip_tags($this->price));
            $this->city_id=htmlspecialchars(strip_tags($this->city_id));
            $this->organization_id=htmlspecialchars(strip_tags($this->organization_id));
            $this->category_id=htmlspecialchars(strip_tags($this->category_id));
            $this->id=htmlspecialchars(strip_tags($this->id));

            // bind values
            $stmt->bindParam(":service_name", $this->service_name);
            $stmt->bindParam(":description", $this->description);
            $stmt->bindParam(":price_type_id", $this->price_type_id);
            $stmt->bindParam(":price", $this->price);
            $stmt->bindParam(":city", $this->city_id);
            $stmt->bindParam(":organization_id", $this->organization_id);
            $stmt->bindParam(":category_id", $this->category_id);
            $stmt->bindParam(":id", $this->id);

            // execute query
            if($stmt->execute()){
                return true;
            }

            return false;
        }


        // function for deleting service
        public function delete(){
            // query to delete
            $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // bind data 
            $stmt->bindParam(1, $this->id);

            // execute query
            if($stmt->execute()){
                return true;
            }

            return false;

        }


        // function for reading single service
        public function readOne(){
            // query to read single record
            $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // bind parameters 
            $stmt->bindParam(1, $this->id);

            // execute query
            $stmt->execute();

            // get retrieved row
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // set values to object properties
            $this->service_name = $row['service_name'];
            $this->description = $row['description'];
            $this->price_type_id = $row['price_type_id'];
            $this->price = $row['price'];
            $this->city_id = $row['city_id'];
            $this->organization_id = $row['organization_id'];
            $this->category_id = $row['category_id'];
        }

        // function to check if id is present or not
        function isIdPresent(){
            // query to read single record
            $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // bind parameters 
            $stmt->bindParam(1, $this->id);

            // execute query
            $stmt->execute();

            // get retrieved row
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // set values to object properties
            if ($row) {
                return true;
            }
            return false;
        }

        
        // get OrganizationModel object by id
        function getOrganizationModelById(){
            $organization_model = new OrganizationModel($this->conn);
            $organization_model->id = $this->organization_id;
            $organization_model->readOne();
            return $organization_model;
        }

        
        // get PriceType for given service
        function getPriceType(){
            $price_type_model = new PriceTypeModel($this->conn);
            return $price_type_model->getTypeFromId($this->price_type_id);
        }


        // get Category for given service
        function getCategory(){
            $category_model = new CategoryModel($this->conn);
            return $category_model->getCategoryFromId($this->category_id);
        }

        

    }


?>