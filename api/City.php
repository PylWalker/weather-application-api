<?php
    class City{
      
        // database connection and table name
        private $conn;
        private $table_name = "city";
      
        // object properties
        public $id;
        public $name;
        public $country = "Việt Nam";
        public $lat;
        public $lon;
      
        // constructor with $db as database connection
        public function __construct($db){
            $this->conn = $db;
        }

        // read cities
        function read($name){
          
            // select all query
            $query = "select * from city where name like '%$name%' limit 10";
          
            // prepare query statement
            $stmt = $this->conn->prepare($query);
          
            // execute query
            $stmt->execute();
          
            return $stmt;
        }

        function readExactly($name){
          
            // select all query
            $query = "select lat, lon from city where name = '$name'";
          
            // prepare query statement
            $stmt = $this->conn->prepare($query);
          
            // execute query
            $stmt->execute();
          
            return $stmt;
        }
    }
?>