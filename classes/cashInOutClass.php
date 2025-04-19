<?php
require_once '../../classes/databaseClass.php';

class CashInOutClass {
    public $connection;

    public function __construct() {
        $database = new Database(); // Connect to the database
        $this->connection = $database->connect();
    }

    /**
     * Fetch all cash-in records
     */
    public function fetchCashIn() {
        $query = "SELECT ci.id, ci.collection_date, ci.amount, ci.school_year_id, sy.school_year, ci.created_by, a.username AS created_by_name
                  FROM cash_in ci
                  JOIN school_year sy ON ci.school_year_id = sy.school_year_id
                  JOIN account a ON ci.created_by = a.user_id
                  ORDER BY ci.collection_date DESC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Fetch all cash-out records
     */
    public function fetchCashOut() {
        $query = "SELECT co.id, co.cashout_date, co.expense_details, co.expense_category, co.amount, co.school_year_id, sy.school_year, co.created_by, a.username AS created_by_name
                  FROM cash_out co
                  JOIN school_year sy ON co.school_year_id = sy.school_year_id
                  JOIN account a ON co.created_by = a.user_id
                  ORDER BY co.cashout_date DESC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get total cash-in
     */
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

    /**
     * Get total cash-out
     */
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

    /**
     * Add a cash-in record
     */
    public function addCashIn($collectionDate, $amount, $schoolYearId, $createdBy) {
        try {
            $sql = "INSERT INTO cash_in (collection_date, amount, school_year_id, created_by) VALUES (?, ?, ?, ?)";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$collectionDate, $amount, $schoolYearId, $createdBy]);
            return true;
        } catch (PDOException $exception) {
            die("Error adding cash-in: " . $exception->getMessage());
        }
    }

    /**
     * Add a cash-out record
     */
    public function addCashOut($cashOutDate, $amount, $details, $category, $schoolYearId, $createdBy) {
        try {
            $sql = "INSERT INTO cash_out (cashout_date, amount, expense_details, expense_category, school_year_id, created_by) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$cashOutDate, $amount, $details, $category, $schoolYearId, $createdBy]);
            return true;
        } catch (PDOException $exception) {
            die("Error adding cash-out: " . $exception->getMessage());
        }
    }

    /**
     * Fetch cash-in records by school year
     */
    public function fetchCashInByYear($schoolYearId) {
        $query = "SELECT ci.id, ci.collection_date, ci.amount, ci.school_year_id, sy.school_year, ci.created_by, a.username AS created_by_name
                  FROM cash_in ci
                  JOIN school_year sy ON ci.school_year_id = sy.school_year_id
                  JOIN account a ON ci.created_by = a.user_id
                  WHERE ci.school_year_id = ?
                  ORDER BY ci.collection_date DESC";
        $statement = $this->connection->prepare($query);
        $statement->execute([$schoolYearId]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Fetch cash-out records by school year
     */
    public function fetchCashOutByYear($schoolYearId) {
        $query = "SELECT co.id, co.cashout_date, co.expense_details, co.expense_category, co.amount, co.school_year_id, sy.school_year, co.created_by, a.username AS created_by_name
                  FROM cash_out co
                  JOIN school_year sy ON co.school_year_id = sy.school_year_id
                  JOIN account a ON co.created_by = a.user_id
                  WHERE co.school_year_id = ?
                  ORDER BY co.cashout_date DESC";
        $statement = $this->connection->prepare($query);
        $statement->execute([$schoolYearId]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Fetch all school years
     */
    public function fetchSchoolYears() {
        $query = "SELECT school_year_id, school_year FROM school_year ORDER BY school_year DESC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

   
        public function fetchMonthlyCashInOut($year) {
            // Query to fetch monthly cash in and out for the specified year
            $query = "SELECT MONTH(collection_date) AS month, SUM(amount) AS total_cash_in
                      FROM cash_in
                      WHERE YEAR(collection_date) = ?
                      GROUP BY MONTH(collection_date)";
            // Execute the query and return results...
    
            $queryOut = "SELECT MONTH(cashout_date) AS month, SUM(amount) AS total_cash_out
                          FROM cash_out
                          WHERE YEAR(cashout_date) = ?
                          GROUP BY MONTH(cashout_date)";
            // Execute the query and return results...
        }
    
        public function fetchCategoryWiseCashOut($year) {
            // Query to fetch cash out by category for the specified year
            $query = "SELECT expense_category, SUM(amount) AS total_amount
                      FROM cash_out
                      WHERE YEAR(cashout_date) = ?
                      GROUP BY expense_category";
            // Execute the query and return results...
        }
    
}
?>