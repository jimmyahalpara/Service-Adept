<?php 
    require_once __DIR__ . '/../../Utilities/preventDirectAccess.php';

    class PaymentModel {
        // database connection and table name
        private $conn;
        private $table_name = "payments";

        // object properties
        public $id;
        public $user_id;
        public $service_order_id;
        public $amount;
        public $is_paid = 0;
        
        // constructor with $db as database connection
        public function __construct($db) {
            $this->conn = $db;
        }

        // read payments
        function read() {
            // select all query
            $query = "SELECT * FROM " . $this->table_name;

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // execute query
            $stmt->execute();

            return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        
        }

        // create payment
        function create() {
            // query to insert record
            $query = "INSERT INTO
                        " . $this->table_name . "
                    (
                        user_id,
                        service_order_id,
                        amount,
                        is_paid
                    ) VALUES (
                        :user_id,
                        :service_order_id,
                        :amount,
                        :is_paid
                    )";

            // prepare query
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this->user_id=htmlspecialchars(strip_tags($this->user_id));
            $this->service_order_id=htmlspecialchars(strip_tags($this->service_order_id));
            $this->amount=htmlspecialchars(strip_tags($this->amount));
            $this->is_paid=htmlspecialchars(strip_tags($this->is_paid));

            // bind values
            $stmt->bindParam(":user_id", $this->user_id);
            $stmt->bindParam(":service_order_id", $this->service_order_id);
            $stmt->bindParam(":amount", $this->amount);
            $stmt->bindParam(":is_paid", $this->is_paid);

            // execute query
            if($stmt->execute()) {
                // set new id 
                $this->id = $this->conn->lastInsertId();
                return true;
            }

            return false;
        }


        // read one payment
        function readOne(){
            // query to read single record
            $query = "SELECT
                        *
                    FROM
                        " . $this->table_name . "
                    WHERE
                        id = ?
                    LIMIT
                        0,1";

            // prepare query statement
            $stmt = $this->conn->prepare( $query );

            // sanitize the parameters 
            $this -> id = htmlspecialchars(strip_tags($this -> id));

            // bind id of record to be updated
            $stmt -> bindParam(1, $this -> id);

            // execute query
            $stmt -> execute();

            // get retrieved row
            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            $this -> user_id = $row["user_id"];
            $this -> service_order_id = $row["service_order_id"];
            $this -> amount = $row["amount"];
            $this -> is_paid = $row["is_paid"];

        }

        // function to set payment as paid 
        function setAsPaid(){
            // query to update record
            $query = "UPDATE
                        " . $this->table_name . "
                    SET
                        is_paid = 1
                    WHERE
                        id = ?";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // sanitize the parameters 
            $this -> id = htmlspecialchars(strip_tags($this -> id));

            // bind id of record to be updated
            $stmt -> bindParam(1, $this -> id);

            // execute query
            if($stmt->execute()) {
                return true;
            }

            return false;
        }


        // function to check id is present or not
        function isIdPresent(){
            // query to read single record
            $query = "SELECT
                        *
                    FROM
                        " . $this->table_name . "
                    WHERE
                        id = ?
                    LIMIT
                        0,1";

            // prepare query statement
            $stmt = $this->conn->prepare( $query );

            // sanitize parameters 
            $this -> id = htmlspecialchars(strip_tags($this -> id));

            // bind id of record to be updated
            $stmt -> bindParam(1, $this -> id);

            // execute query
            $stmt -> execute();

            // get retrieved row
            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return true;
            } 

            return false;
        }


        // function to check if user_id is present or not 
        function isUserIdPresent(){
            // query to read single record
            $query = "SELECT
                        *
                    FROM
                        " . $this->table_name . "
                    WHERE
                        user_id = ?
                    LIMIT
                        0,1";

            // prepare query statement
            $stmt = $this->conn->prepare( $query );

            // sanitize parameters 
            $this -> user_id = htmlspecialchars(strip_tags($this -> user_id));

            // bind id of record to be updated
            $stmt -> bindParam(1, $this -> user_id);

            // execute query
            $stmt -> execute();

            // get retrieved row
            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return true;
            } 

            return false;
        }

        
        // function to check if service_order_id is present or not
        function isServiceOrderIdPresent(){
            // query to read single record
            $query = "SELECT
                        *
                    FROM
                        " . $this->table_name . "
                    WHERE
                        service_order_id = ?
                    LIMIT
                        0,1";

            // prepare query statement
            $stmt = $this->conn->prepare( $query );

            // sanitize parameters 
            $this -> service_order_id = htmlspecialchars(strip_tags($this -> service_order_id));

            // bind id of record to be updated
            $stmt -> bindParam(1, $this -> service_order_id);

            // execute query
            $stmt -> execute();

            // get retrieved row
            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return true;
            } 

            return false;
        }


        // function to return userModel for user_id
        function getUserModel(){
            $user = new UserModel($this->conn);
            $user->id = $this->user_id;
            $user->readOne();
            return $user;
        }


        // function to return serviceOrderModel for service_order_id
        function getServiceOrderModel(){
            $serviceOrder = new ServiceOrderModel($this->conn);
            $serviceOrder->id = $this->service_order_id;
            $serviceOrder->readOne();
            return $serviceOrder;
        }
        

    }

?>