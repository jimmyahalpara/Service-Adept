<?php 
    require_once __DIR__ . '/../../Utilities/preventDirectAccess.php';

    class ServiceProviderModel {
        // database connection
        private $conn;
        // table name
        private $table_name = "ServiceProvider";

        // object properties
        public $id;
        public $service_id;
        public $provider_id;

        // constructor with $db as database connection
        public function __construct($db) {
            $this->conn = $db;
        }

        // function to read service providers from table
        function read(){
            // query to read all service providers
            $query = "SELECT * FROM " . $this->table_name;

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // execute query
            $stmt->execute();

            return $stmt -> fetchAll(PDO::FETCH_ASSOC);

        }

        // function to create service provider
        function create(){
            // query to insert service provider
            $query = "INSERT INTO " . $this->table_name . "
            SET
                service_id = :service_id,
                provider_id = :provider_id";

            // prepare query
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this->service_id = htmlspecialchars(strip_tags($this->service_id));
            $this->provider_id = htmlspecialchars(strip_tags($this->provider_id));


            // check if provider with provider_id and service with service_id has same organization_id
            $serviceModel = new ServiceModel($this->conn);
            $serviceModel -> id = $this->service_id;
            $serviceModel -> readOne();

            $providerModel = new ProviderModel($this->conn);
            $providerModel -> id = $this->provider_id;
            $providerModel -> readOneById();

            if ($serviceModel -> organization_id != $providerModel -> organization_id) {
                return false;
            }

            // bind values
            $stmt->bindParam(":service_id", $this->service_id);
            $stmt->bindParam(":provider_id", $this->provider_id);

            // execute query
            if($stmt->execute()){
                return true;
            }

            return false;
        }

        // function to delete service provider
        function delete(){
            // query
            $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

            // prepare query
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this -> id = htmlspecialchars(strip_tags($this -> id));

            // bind parametrs
            $stmt -> bindParam(":id", $this -> id);

            // execute query
            if($stmt -> execute()){
                return true;
            }

            return false;
        }

        
        // function to read one service provider
        function readOne(){
            // query to read
            $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";

            // prepare query
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this -> id = htmlspecialchars(strip_tags($this -> id));

            // bind parametrs
            $stmt -> bindParam(":id", $this -> id);

            // execute query
            $stmt -> execute();
            $result = $stmt -> fetch(PDO::FETCH_ASSOC);

            // set values to object properties
            $this -> service_id = $result['service_id'];
            $this -> provider_id = $result['provider_id'];

        }


        // check if id exists or not 
        function isIdPresnet(){
            // query to read
            $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";

            // prepare query
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this -> id = htmlspecialchars(strip_tags($this -> id));

            // bind parametrs
            $stmt -> bindParam(":id", $this -> id);

            // execute query
            $stmt -> execute();

            // get result 
            $result = $stmt -> fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return true;
            }

            return false;
        }
    }

?>