<?php 
class Database{

    protected $connection;

    function connect(){
        try {
            $this->connection = new PDO("mysql:host=localhost;dbname=phicss","root","");
            // echo "Connection success!";
        } catch (PDOException $e) {
            echo "ERROR MESSAGE: " . $e->getMessage();
        }
        
        return $this->connection;
    }
}

// $objdb = new Database;
// $objdb->connect();
?>