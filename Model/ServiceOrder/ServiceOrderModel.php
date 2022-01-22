<?php 
    require_once __DIR__ . '/../../Utilities/preventDirectAccess.php';



    class ServiceOrderModel {
        // database connection 
        private $conn;
        // table name
        private $table_name = "ServiceOrder";

        // object properties
        public $id;
        public $user_id;
        public $service_provider_id;
        public $quantity;
        public $time;
        public $date;
        public $subscription;
        public $completed;
        
        // constructor with $db as database connection
        public function __construct($db) {
            $this->conn = $db;
        }

        // function to read service orders from table
        function read(){
            // query to read all service orders
            $query = "SELECT * FROM " . $this->table_name;

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // execute query
            $stmt->execute();

            return $stmt -> fetchAll(PDO::FETCH_ASSOC);

        }


        // function to readOne service order from table
        function readOne(){
            // query to read one service order
            $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // sanitize the value 
            $this->id=htmlspecialchars(strip_tags($this->id));

            // bind id of service order to be updated
            $stmt->bindParam(1, $this->id);

            // execute query
            $stmt->execute();

            $result =  $stmt -> fetch(PDO::FETCH_ASSOC);

            // set values to object properties
            $this->user_id = $result['user_id'];
            $this->service_provider_id = $result['service_provider_id'];
            $this->quantity = $result['quantity'];
            $this->time = $result['time'];
            $this->date = $result['date'];
            $this->subscription = $result['subscription'];
            $this->completed = $result['completed'];

        }
        
    }
?>