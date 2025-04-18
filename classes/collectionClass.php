<?php
require_once '../../classes/databaseClass.php';

class CollectionClass {
    public $connection;

    public function __construct() {
        $database = new Database(); // Connect to the database
        $this->connection = $database->connect();
    }

    /**
     * Fetch all collections
     */
    public function fetchCollections() {
        try {
            $query = "SELECT * FROM collection ORDER BY id ASC";
            $statement = $this->connection->prepare($query);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            die("Error fetching collections: " . $exception->getMessage());
        }
    }
    

    /**
     * Fetch cashIn records for a specific collection
     */
    public function fetchCashIn() {
        $query = "SELECT ci.id, ci.collection_date, ci.amount, ci.created_by, a.username AS created_by_name
                  FROM cash_in ci
                  JOIN account a ON ci.created_by = a.user_id
                  ORDER BY ci.collection_date DESC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function fetchCashOut() {
        $query = "SELECT co.id, co.cashout_date, co.expense_details, co.expense_category, co.amount, co.created_by, a.username AS created_by_name
                  FROM cash_out co
                  JOIN account a ON co.created_by = a.user_id
                  ORDER BY co.cashout_date DESC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function getTotalCashOut() {
        try {
            $query = "SELECT SUM(amount) AS totalCashOut FROM cash_out";
            $statement = $this->connection->prepare($query);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result['totalCashOut'] ?? 0; // Default to 0 if no records
        } catch (PDOException $exception) {
            die("Error fetching total cash-out: " . $exception->getMessage());
        }
    }

    public function getTotalCashIn() {
        try {
            $query = "SELECT SUM(amount) AS totalCashIn FROM cash_in";
            $statement = $this->connection->prepare($query);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result['totalCashIn'] ?? 0; // Default to 0 if no records
        } catch (PDOException $exception) {
            die("Error fetching total cash-in: " . $exception->getMessage());
        }
    }


        public function addCashIn($collectionId, $collectionDate, $amount) {
            $sql = "INSERT INTO cash_in (collection_id, collection_date, amount)
                    VALUES (?, ?, ?)";
            $stmt = $this->connection->prepare($sql);
            return $stmt->execute([$collectionId, $collectionDate, $amount]);
        }

// Do the same for fetchCashOut(), getTotalCashIn(), getTotalCashOut()

    

}
?>