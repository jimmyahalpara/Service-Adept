<?php
    // prevent direct access using preVentDirectAccess.php
    include __DIR__. "/../../Utilities/preventDirectAccess.php";
    
    class PriceTypeModel {
        // store databse connection 
        private $database;
        // store table name 
        private $tableName = "PriceType";
        
        // constructor
        public function __construct($database) {
            $this->database = $database;
        }
        
        // get all price types
        public function getAllPriceTypes() {
            $sql = "SELECT * FROM " . $this->tableName;
            $statement = $this->database->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll();
            $statement->closeCursor();
            return $result;
        }
        
        // get type from id 
        public function getTypeFromId($id) {
            $sql = "SELECT * FROM " . $this->tableName . " WHERE id = :id";
            $statement = $this->database->prepare($sql);
            $statement->bindValue(":id", $id);
            $statement->execute();
            $result = $statement->fetch();
            $statement->closeCursor();

            // return type from result
            return $result["type"];
        }
        
    }
    
    ?>
