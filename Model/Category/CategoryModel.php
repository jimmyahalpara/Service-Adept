<?php 
    require_once __DIR__ . '/../../Utilities/preventDirectAccess.php';
    
    
    
    class CategoryModel {
        private $conn;
        private $table = 'Category';
        
        public $id;
        public $name;
        
        public function __construct($db) {
            $this->conn = $db;
        }
        
        public function read(){
            // Create query
            $query = 'SELECT id, name FROM ' . $this->table;
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            
            // Execute query
            $stmt->execute();
            
            $result = $stmt -> fetchAll(PDO::FETCH_ASSOC);
            
            return $result;
        }

        // get category name from id
        public function getCategoryFromId($id){
            // Create query
            $query = 'SELECT name FROM ' . $this->table . ' WHERE id = :id';
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            
            // Bind values
            $stmt->bindValue(':id', $id);
            
            // Execute query
            $stmt->execute();
            
            $result = $stmt -> fetch(PDO::FETCH_ASSOC);
            
            return $result['name'];
        }
        
    }
    
    
    
?>
