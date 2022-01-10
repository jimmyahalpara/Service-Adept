<?php
    // prevent direct access using preventDirectAccess.php

    include __DIR__ . '/../../Utilities/preventDirectAccess.php';

    // include CustomerCareExecutiveModel.php
    include __DIR__ . '/../CustomerCareExecutive/CustomerCareExecutiveModel.php';


    class ComplaintModel {
        // database connection 
        private $conn;
        // table name
        private $table_name = "Complaint";


        // object properties
        public $id;
        public $user_id;
        public $executive_id;
        public $status;
        public $create_date;
        public $description;

        // constructor with $db as database connection
        public function __construct($db){
            $this->conn = $db;
        }

        // function to read Complaint from the table
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


        // function for creating new Complaint
        public function create(){
            // insert query
            $query = "INSERT INTO " . $this->table_name . " (user_id, executive_id, status, description) VALUES (:user_id, :executive_id, :status, :description)";

            // prepare query statement
            $stmt = $this->conn->prepare($query);
            
            // sanitize
            $this->user_id=htmlspecialchars(strip_tags($this->user_id));
            $this->executive_id=htmlspecialchars(strip_tags($this->executive_id));
            $this->status=htmlspecialchars(strip_tags($this->status));
            $this->description=htmlspecialchars(strip_tags($this->description));

            // bind values
            $stmt->bindParam(":user_id", $this->user_id);
            $stmt->bindParam(":executive_id", $this->executive_id);
            $stmt->bindParam(":status", $this->status);
            $stmt->bindParam(":description", $this->description);

            // execute query
            if ($stmt->execute()){
                // get id of the created complaint
                $this->id = $this->conn->lastInsertId();

                // increase care count of executive
                $customerCareExecutiveModel = new CustomerCareExecutiveModel($this->conn);
                $customerCareExecutiveModel -> id = $this -> executive_id;
                $customerCareExecutiveModel -> readOne();
                // var_dump($customerCareExecutiveModel -> care_count);
                $customerCareExecutiveModel -> increaseCareCount();
                return true;
            }

            return false;
        }


        // function for updating Complaint
        public function update(){
            // update query
            $query = "UPDATE " . $this->table_name . "(user_id, executive_id, status, description) VALUES (:user_id, :executive_id, :status, :description) WHERE id = :id";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this->status=htmlspecialchars(strip_tags($this->status));
            $this->description=htmlspecialchars(strip_tags($this->description));
            $this->id=htmlspecialchars(strip_tags($this->id));

            // bind values
            $stmt->bindParam(":status", $this->status);
            $stmt->bindParam(":description", $this->description);
            $stmt->bindParam(":id", $this->id);

            // execute query
            if ($stmt->execute()){
                return true;
            }

            return false;
        }


        // function for deleting Complaint
        public function delete(){
            // delete query
            $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

            // prepare query
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this->id=htmlspecialchars(strip_tags($this->id));

            // bind id of record to delete
            $stmt->bindParam(1, $this->id);

            // execute query
            if ($stmt->execute()){
                // decrese executive carecount 
                $customerCareExecutiveModel = new CustomerCareExecutiveModel($this->conn);
                $customerCareExecutiveModel -> id = $this -> executive_id;
                $customerCareExecutiveModel -> readOne();
                $customerCareExecutiveModel -> decreaseCareCount();


                return true;
            }

            return false;
        }


        // function for reading one Complaint
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
            $this->user_id = $row['user_id'];
            $this->executive_id = $row['executive_id'];
            $this->status = $row['status'];
            $this->description = $row['description'];
        }


        // function for reading all Complaint by executive id
        public function readAllByExecutiveId(){
            // query to read all complaints by executive id
            $query = "SELECT * FROM " . $this->table_name . " WHERE executive_id = ?";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this->executive_id=htmlspecialchars(strip_tags($this->executive_id));

            // bind id of record to read
            $stmt->bindParam(1, $this->executive_id);

            // execute query
            $stmt->execute();

            // get retrieved row
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        }

        // function for reading all Complaint by user id
        public function readAllByUserId(){
            // query to read all complaints by user id
            $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = ?";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this->user_id=htmlspecialchars(strip_tags($this->user_id));

            // bind id of record to read
            $stmt->bindParam(1, $this->user_id);

            // execute query
            $stmt->execute();

            // get retrieved row
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        }

        
        // check if user_id is present 
        public function checkUserId(){
            // query to read single record
            $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = ?";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this->user_id=htmlspecialchars(strip_tags($this->user_id));

            // bind id of record to read
            $stmt->bindParam(1, $this->user_id);

            // execute query
            $stmt->execute();

            // get retrieved row
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // set values to object properties
            if ($row){
                return true;
            }
            return false;
        }


        // check if executive_id is present
        public function checkExecutiveId(){
            // query to read single record
            $query = "SELECT * FROM " . $this->table_name . " WHERE executive_id = ?";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this->executive_id=htmlspecialchars(strip_tags($this->executive_id));

            // bind id of record to read
            $stmt->bindParam(1, $this->executive_id);

            // execute query
            $stmt->execute();

            // get retrieved row
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // set values to object properties
            if ($row){
                return true;
            }
            return false;
        }


        // check if id is present
        public function checkId(){
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
            if ($row){
                return true;
            }
            return false;
        }


        // get userModel from user_id
        function getUserModel(){
            $userModel = new UserModel($this->conn);
            $userModel -> id = $this -> user_id;
            $userModel -> readOne();
            return $userModel;
        }

        // get customerCareExecutiveModel from executive_id
        function getCustomerCareExecutiveModel(){
            $customerCareExecutiveModel = new CustomerCareExecutiveModel($this->conn);
            $customerCareExecutiveModel -> id = $this -> executive_id;
            $customerCareExecutiveModel -> readOne();
            return $customerCareExecutiveModel;
        }

        
    }
?>