<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../class/post.php';

$database = new Database();
$db = $database->getConnection();
$posts = new Post($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    $data = json_decode(file_get_contents("php://input"));
    $posts->post_id = $data->post_id;
    if ($data->vote_type=='down')
    {
        $posts->downvotePost();
    }
    else if ($data->vote_type=='up')
    {
        $posts->upvotePost();
    }
    echo json_encode(
        array("message" => "OK!")
    );
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "Error.")
    );
}
