<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: appliaction/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//instantiate blog post object
$post = new Post($db);

// Blog post query
$result = $post->read();

//Get row count 
$num = $result->RowCount();

//Check if any posts

if($num > 0){
    //Post array
    $posts_arr = array();
    $posts_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $post_item = array(
            'id' => $id,
            'title' => $title,
            'body' => html_entity_decode($body),
            'author' => $author,
            'category_id' => $category_id,
            'category_name' => $category_name,
        );
        // push to "data"
        array_push($posts_arr['data'], $post_item);
    }

    // Turn to json & output
    echo json_encode($posts_arr);
} else {
    echo json_encode(
        array('message' => 'No Post Found')
    );
}


