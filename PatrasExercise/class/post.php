<?php
class Post
{
    // Conn
    private $conn;
    // Columns
    public $post_id;
    public $post_title;
    public $author_name;
    public $post_text;
    public $post_upvotes;
    public $post_downvotes;
    public $categories;
    public $category_id;
    // Db connection
    public function __construct($db)
    {
        $this->conn = $db;
    }
    // GetAllPosts
    public function getPosts()
    {
        $sqlQuery = "SELECT posts.post_id, posts.post_title, posts.author_name, posts.post_text, posts.post_downvotes, posts.post_upvotes, Group_concat(post_categories.category_id) category_id, Group_concat(categories.category_name) category_name FROM posts INNER JOIN post_categories ON posts.post_id = post_categories.post_id INNER JOIN categories ON post_categories.category_id = categories.category_id GROUP BY posts.post_id, posts.post_title";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    //Get Posts Based on Category_Id
    public function getPostsByCategory(){
        $sqlQuery = "SELECT posts.post_id, posts.post_title, posts.author_name, posts.post_text, posts.post_downvotes, posts.post_upvotes, Group_concat(post_categories.category_id) category_id, Group_concat(categories.category_name) category_name FROM posts INNER JOIN post_categories ON posts.post_id = post_categories.post_id INNER JOIN categories ON post_categories.category_id = categories.category_id WHERE post_categories.category_id = :category_id GROUP BY posts.post_id, posts.post_title";
        $stmt = $this->conn->prepare($sqlQuery);
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->execute();
        return $stmt;
    }


    //downvotePost
    public function downvotePost()
    {
        $sqlQuery = "UPDATE posts SET post_downvotes = post_downvotes + 1 WHERE post_id = :post_id ";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(":post_id", $this->post_id);
        $stmt->execute();
        return $stmt;
    }

    //upvotePost
    public function upvotePost()
    {
        $sqlQuery = "UPDATE posts SET post_upvotes = post_upvotes + 1 WHERE post_id = :post_id ";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(":post_id", $this->post_id);
        $stmt->execute();
        return $stmt;
    }
    // CreatePost
    public function createPost()
    {
        $this->conn->beginTransaction();
        $sqlQuery = "INSERT INTO posts
                    SET
                        post_title = :post_title, 
                        author_name = :author_name, 
                        post_text = :post_text,
                        post_upvotes = 0,
                        post_downvotes = 0";

        $stmt = $this->conn->prepare($sqlQuery);

        // Sanitize Input
        $this->post_title = htmlspecialchars(strip_tags($this->post_title));
        $this->author_name = htmlspecialchars(strip_tags($this->author_name));
        $this->post_text = htmlspecialchars(strip_tags($this->post_text));
        // Bind Parameters
        $stmt->bindParam(":post_title", $this->post_title);
        $stmt->bindParam(":author_name", $this->author_name);
        $stmt->bindParam(":post_text", $this->post_text);

        if ($stmt->execute()) {
            $id = $this->conn->lastInsertId();
            for ($i=0; $i<count($this->categories); $i++)
            {
                $sql = $this->conn->prepare('INSERT INTO post_categories VALUES (:post_id, :category_id)');
                $sql->bindparam(":post_id", $id);

                $this->categories[$i] = htmlspecialchars(strip_tags($this->categories[$i]));

                $sql->bindparam(":category_id", $this->categories[$i]);
                $sql->execute();
            }
        }
        return false;
    }
}
