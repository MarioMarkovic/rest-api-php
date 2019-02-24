<?php 

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
	
require_once(realpath(dirname(__FILE__) . '/../../app/config/DB.php'));
require_once(realpath(dirname(__FILE__) . '/../../app/models/Post.php'));

$data = json_decode(file_get_contents("php://input"));

if(!empty($data)) {

	$params = [
		":id" => htmlspecialchars(strip_tags($data->id)),
		":title" => htmlspecialchars(strip_tags($data->title)), 
		":body" => htmlspecialchars(strip_tags($data->body)), 
		":author" => htmlspecialchars(strip_tags($data->author)), 
		":category_id" => htmlspecialchars(strip_tags($data->category_id))
	];

	$update = DB::connection()->update("UPDATE posts SET title=:title, body=:body, author=:author, category_id=:category_id WHERE id=:id", $params);

	if($update) {
		echo json_encode(['message' => "Post updated", 'Title' => $data->title ]);
	} else {
		echo json_encode(['message' => "Post not updated"]);
	}

} else {
	die();
}



