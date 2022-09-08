<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../class/category.php';

$database = new Database();
$db = $database->getConnection();
$categories = new Category($db);
$stmt = $categories->getAllCategories();
$categories_count = $stmt->rowCount();
if ($categories_count > 0) {

    $categories_array = array();
    $categories_array["body"] = array();
    $categories_array["item_count"] = $categories_count;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $e = array(
            "category_id" => $category_id,
            "category_name" => $category_name
        );
        array_push($categories_array["body"], $e);
    }
    echo json_encode($categories_array);
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No categories found.")
    );
}
?>