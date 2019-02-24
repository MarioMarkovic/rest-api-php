<?php 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
	
require_once(realpath(dirname(__FILE__) . '/../../app/config/DB.php'));
require_once(realpath(dirname(__FILE__) . '/../../app/models/Post.php'));

$data = json_decode(file_get_contents("php://input"));

if(!empty($data)) {

	$params = [
		":title" => htmlspecialchars(strip_tags($data->title)), 
		":body" => htmlspecialchars(strip_tags($data->body)), 
		":author" => htmlspecialchars(strip_tags($data->author)), 
		":category_id" => htmlspecialchars(strip_tags($data->category_id))
	];

	$insert = DB::connection()->insert("INSERT INTO posts SET title=:title, body=:body, author=:author, category_id=:category_id", $params);

	if($insert) {
		echo json_encode(['message' => "Post created", 'Id' => $insert->getLastInsertedId() ]);
	} else {
		echo json_encode(['message' => "Post not created"]);
	}

} else {
	die();
}



