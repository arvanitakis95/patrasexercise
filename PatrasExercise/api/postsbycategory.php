<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../class/post.php';

$category_id=$_GET['category_id'];

$database = new Database();
$db = $database->getConnection();
$posts = new Post($db);
$posts->category_id=$category_id;
$stmt = $posts->getPostsByCategory();
$posts_count = $stmt->rowCount();
if ($posts_count > 0) {

    $posts_array = array();
    $posts_array["body"] = array();
    $posts_array["item_count"] = $posts_count;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $e = array(
            "post_id" => $post_id,
            "post_title" => $post_title,
            "author_name" => $author_name,
            "post_text" => $post_text,
            "post_downvotes" => $post_downvotes,
            "post_upvotes" => $post_upvotes,
            "category_id" => $category_id,
            "category_name" => $category_name,
        );
        array_push($posts_array["body"], $e);
    }
    echo json_encode($posts_array);
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No posts found.")
    );
}
?>