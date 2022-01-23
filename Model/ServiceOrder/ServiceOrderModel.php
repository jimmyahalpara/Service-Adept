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

        // function to readAll by service_provider_id from table
        function readAllByServiceProviderId(){
            // query to read all service orders
            $query = "SELECT * FROM " . $this->table_name . " WHERE service_provider_id = ?";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // sanitize the value 
            $this->service_provider_id=htmlspecialchars(strip_tags($this->service_provider_id));

            // bind id of service order to be updated
            $stmt->bindParam(1, $this->service_provider_id);

            // execute query
            $stmt->execute();

            return $stmt -> fetchAll(PDO::FETCH_ASSOC);

        }

        // function to readAll by user_id from table
        function readAllByUserId(){
            // query to read all service orders
            $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = ?";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // sanitize the value 
            $this->user_id=htmlspecialchars(strip_tags($this->user_id));

            // bind id of service order to be updated
            $stmt->bindParam(1, $this->user_id);

            // execute query
            $stmt->execute();

            return $stmt -> fetchAll(PDO::FETCH_ASSOC);

        }

        // function to get userModel for user_id 
        function getUserModel(){
            $user = new UserModel($this->conn);
            $user->id = $this->user_id;
            $user->readOne();
            return $user;
        }

        // function to get serviceProviderModel for service_provider_id
        function getServiceProviderModel(){
            $serviceProvider = new ServiceProviderModel($this->conn);
            $serviceProvider->id = $this->service_provider_id;
            $serviceProvider->readOne();
            return $serviceProvider;
        }

        // function to get ServiceModel from serviceProviderModel
        function getServiceModel(){
            $serviceProvider = $this->getServiceProviderModel();
            $service = $serviceProvider->getServiceModel();
            return $service;
        }

        // function to create service order
        function create(){
            // query to insert record
            $query = "INSERT INTO
                        " . $this->table_name . "
                    (
                        user_id,
                        service_provider_id,
                        quantity,
                        time,
                        date,
                        subscription,
                        completed
                    ) VALUES (
                        :user_id,
                        :service_provider_id,
                        :quantity,
                        :time,
                        :date,
                        :subscription,
                        :completed
                    )";

            // prepare query
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this->user_id=htmlspecialchars(strip_tags($this->user_id));
            $this->service_provider_id=htmlspecialchars(strip_tags($this->service_provider_id));
            $this->quantity=htmlspecialchars(strip_tags($this->quantity));
            $this->time=htmlspecialchars(strip_tags($this->time));
            $this->date=htmlspecialchars(strip_tags($this->date));
            $this->subscription=htmlspecialchars(strip_tags($this->subscription));
            $this->completed=htmlspecialchars(strip_tags($this->completed));

            // bind values
            $stmt->bindParam(":user_id", $this->user_id);
            $stmt->bindParam(":service_provider_id", $this->service_provider_id);
            $stmt->bindParam(":quantity", $this->quantity);
            $stmt->bindParam(":time", $this->time);
            $stmt->bindParam(":date", $this->date);
            $stmt->bindParam(":subscription", $this->subscription);
            $stmt->bindParam(":completed", $this->completed);

            // execute query
            if($stmt->execute()){
                if ($this->subscription == 0) {
                    // get serviceModel from serviceProviderModel
                    $last_id = $this->conn->lastInsertId();
                    $service = $this->getServiceModel();

                    // create payment for service order and user_id 
                    $payment = new PaymentModel($this->conn);
                    $payment->user_id = $this->user_id;
                    $payment -> service_order_id = $last_id;
                    var_dump("last insert id = ".$last_id);
                    // calculate amount as quantity * service price
                    $amount = $this->quantity * $service->price;
                    $payment->amount = $amount;
                    $payment->create();
                }
                return true;
            }

            return false;
        }
        
    }
?>