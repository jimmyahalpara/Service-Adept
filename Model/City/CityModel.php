<?php
    require_once __DIR__ . '/../../Utilities/preventDirectAccess.php';

    class CityModel {
        // database connection and table name
        private $conn;
        private $table_name = "City";

        // object properties
        public $id;
        public $name;

        // constructor with $db as database connection
        public function __construct($db) {
            $this->conn = $db;
        }

        // read cities from database
        function read(){
            // select all query
            $query = "SELECT * FROM " . $this->table_name;

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // execute query
            $stmt -> execute();

            $result = $stmt -> fetchAll(PDO::FETCH_ASSOC);

            return $result;
        }

        
        // function to return city name by id or false
        function getCityNameById($id){
            // select all query
            $query = "SELECT name FROM " . $this->table_name . " WHERE id = ?";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // sanitize
            $id=htmlspecialchars(strip_tags($id));

            // bind id of city to be updated
            $stmt->bindParam(1, $id);

            // execute query
            $stmt -> execute();

            $result = $stmt -> fetch(PDO::FETCH_ASSOC);
            // var_dump($result);
            if($result){
                return $result['name'];
            } else {
                return false;
            }
        }
    }
?>