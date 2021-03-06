<?php
    // prevent users from directly loading this page
    include __DIR__ . '/../../Utilities/preventDirectAccess.php';


    // include $salt and $hash from config.php from base directory
    include __DIR__.'/../../config.php';
    class UserModel {
        // database connection and table

        // database connection 
        private $conn;
        // table name
        private $table_name = "user";

        // object properties
        public $id;
        public $username;
        public $name;
        // sha256 hashed password
        public $password;
        public $email;
        public $phone;
        public $address;
        public $city_id;
        public $access_level;
        public $gender;
        public $relogin;




        // constructor with $db as database connection
        public function __construct($db) {
            $this->conn = $db;
        }

        // function to read user from table 
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

        // function for creating new user
        public function create(){
            // query to insert record
            $query = "INSERT INTO
                        " . $this->table_name . ' (username, name, password, email, phone, address, city_id, access_level, gender) values (:username,:name,:password,:email,:phone,:address,:city,:access_level,:gender)';
            

            // sanitize username
            $this -> username = htmlspecialchars(strip_tags($this -> username));
            $this -> name = htmlspecialchars(strip_tags($this -> name));
            $this -> password = htmlspecialchars(strip_tags($this -> password));
            $this -> email = htmlspecialchars(strip_tags($this -> email));
            $this -> phone = htmlspecialchars(strip_tags($this -> phone));
            $this -> address = htmlspecialchars(strip_tags($this -> address));
            $this -> city_id = htmlspecialchars(strip_tags($this -> city_id));
            $this -> access_level = htmlspecialchars(strip_tags($this -> access_level));
            $this -> gender = htmlspecialchars(strip_tags($this -> gender));


            // prepare sql statement 
            $stmt = $this -> conn -> prepare($query);
            
            $stmt -> bindParam(':username', $this -> username);
            $stmt -> bindParam(':name', $this -> name);
            $stmt -> bindParam(':password', $this -> password);
            $stmt -> bindParam(':email', $this -> email);
            $stmt -> bindParam(':phone', $this -> phone);
            $stmt -> bindParam(':address', $this -> address);
            $stmt -> bindParam(':city', $this -> city_id);
            $stmt -> bindParam(':access_level', $this -> access_level);
            $stmt -> bindParam(':gender', $this -> gender);

            $stmt -> execute();
            $this -> id = $this ->conn -> lastInsertId();
            

        }

        // function to update user
        public function update(){
            // query to update records
            $query = "UPDATE " . $this->table_name . " SET username=:username, name=:name, password=:password, email=:email, phone=:phone, address=:address, city_id=:city, access_level=:access_level, gender=:gender where id=:id";
            
            // prepare statement

            $stmt = $this -> conn -> prepare($query);

            // sanitize attributes
            $stmt -> username = htmlspecialchars(strip_tags($this -> username));
            $stmt -> name = htmlspecialchars(strip_tags($this -> name));
            $stmt -> password = htmlspecialchars(strip_tags($this -> password));
            $stmt -> email = htmlspecialchars(strip_tags($this -> email));
            $stmt -> phone = htmlspecialchars(strip_tags($this -> phone));
            $stmt -> address = htmlspecialchars(strip_tags($this -> address));
            $stmt -> city_id = htmlspecialchars(strip_tags($this -> city_id));
            $stmt -> access_level = htmlspecialchars(strip_tags($this -> access_level));
            $stmt -> gender = htmlspecialchars(strip_tags($this -> gender));


            // bind parameters
            $stmt -> bindParam(':username', $this -> username);
            $stmt -> bindParam(':name', $this -> name);
            $stmt -> bindParam(':password', $this -> password);
            $stmt -> bindParam(':email', $this -> email);
            $stmt -> bindParam(':phone', $this -> phone);
            $stmt -> bindParam(':address', $this -> address);
            $stmt -> bindParam(':city', $this -> city_id);
            $stmt -> bindParam(':access_level', $this -> access_level);
            $stmt -> bindParam(':gender', $this -> gender);
            $stmt -> bindParam(':id', $this -> id);

            $result = $stmt -> execute();
            if ($result){
                return true;
            } else {
                return false;
            }
            // print_r($result);

        }

        // get one user
        public function readOne(){
            // query to read one user
            $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
            $stmt = $this -> conn -> prepare($query);
            $stmt -> bindParam(1, $this -> id);
            $stmt -> execute();
            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            // set properties
            if ($row){
                $this -> username = $row['username'];
                $this -> name = $row['name'];
                $this -> password = $row['password'];
                $this -> email = $row['email'];
                $this -> phone = $row['phone'];
                $this -> address = $row['address'];
                $this -> city_id = $row['city_id'];
                $this -> access_level = $row['access_level'];
                $this -> gender = $row['gender'];
                $this -> relogin = $row['relogin'];
            } else {
                throw new Exception("No Entry Found with id = ".$this -> id." in table ".$this -> table_name);
            }
        }

        // delete user 
        public function delete(){
            // query to delete user
            $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
            $stmt = $this -> conn -> prepare($query);
            $stmt -> bindParam(1, $this -> id);
            $stmt -> execute();
        }

        public function isIdPresent(){
            $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
            $stmt = $this -> conn -> prepare($query);
            $stmt -> bindParam(1, $this -> id);
            $stmt -> execute();
            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            if ($row){
                return true;
            } else {
                return false;
            }
        }

        public function isUsernamePresent(){
            $query = "SELECT * FROM " . $this->table_name . " WHERE username = ?";
            $stmt = $this -> conn -> prepare($query);
            $stmt -> bindParam(1, $this -> username);
            $stmt -> execute();
            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            if ($row){
                return true;
            } else {
                return false;
            }
        }

        public function isEmailPresent(){
            $query = "SELECT * FROM " . $this->table_name . " WHERE email = ?";
            $stmt = $this -> conn -> prepare($query);
            $stmt -> bindParam(1, $this -> email);
            $stmt -> execute();
            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            if ($row){
                return true;
            } else {
                return false;
            }
        }

        public function isPassCorrectForUsername(){

            $query = "SELECT * FROM " . $this->table_name . " WHERE username = ? AND password = ?";
            $stmt = $this -> conn -> prepare($query);
            $stmt -> bindParam(1, $this -> username);
            $stmt -> bindParam(2, $this -> password);
            $stmt -> execute();
            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            if ($row){
                return true;
            } else {
                return false;
            }
        }

        // readOne using email
        public function readOneUsingEmail(){
            // query to read one user
            $query = "SELECT * FROM " . $this->table_name . " WHERE email = ?";
            $stmt = $this -> conn -> prepare($query);
            $stmt -> bindParam(1, $this -> email);


            // execute query
            $stmt -> execute();
            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            // set properties
            if ($row){
                $this -> id = $row['id'];
                $this -> username = $row['username'];
                $this -> name = $row['name'];
                $this -> password = $row['password'];
                $this -> email = $row['email'];
                $this -> phone = $row['phone'];
                $this -> address = $row['address'];
                $this -> city_id = $row['city_id'];
                $this -> access_level = $row['access_level'];
                $this -> gender = $row['gender'];
                $this -> relogin = $row['relogin'];

                return true;
            } else {
                return false;
            }
        }


        
        // static function hashPassword with $hash and $salt
        public static function hashPassword($password){
            global $hash, $salt;
            return hash($hash, $salt . $password);
        }

        public function isLoginRequired(){
            $query = "SELECT relogin FROM ".$this -> table_name." WHERE id = ?";
            $stmt = $this -> conn -> prepare($query);
            $stmt -> bindParam(1, $this -> id);
            $stmt -> execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return (!$result || $result[0]['relogin'] == 1) ? true: false;
        }

        // function to set relogin required
        public function setReloginRequired(){
            $query = "UPDATE " . $this->table_name . " SET relogin = 1 WHERE id = ?";
            $stmt = $this -> conn -> prepare($query);
            $stmt -> bindParam(1, $this -> id);
            $stmt -> execute();
        }

        // function to set relogin not required
        public function setReloginNotRequired(){
            $query = "UPDATE " . $this->table_name . " SET relogin = 0 WHERE id = ?";
            $stmt = $this -> conn -> prepare($query);
            $stmt -> bindParam(1, $this -> id);
            $stmt -> execute();
        }

        // function to get city from CityModel 
        public function getCity(){

            $city = new CityModel($this -> conn);
            // var_dump($this -> city_id);
            return $city -> getCityNameById($this -> city_id);
        }

        public function getGender(){
            if ($this -> gender == 0){
                return "Female";
            } else if ($this -> gender == 1){
                return "Male";
            } else {
                return "Prefer Not to Tell";
            }
        }
        
    }

?>