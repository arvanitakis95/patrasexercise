<?php
class Category
{
    // Conn
    private $conn;
    // Columns
    public $category_id;
    public $category_name;
    // Db connection
    public function __construct($db)
    {
        $this->conn = $db;
    }
    // GetAllCategories
    public function getAllCategories()
    {
        $sqlQuery = "SELECT * FROM categories";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }
}
