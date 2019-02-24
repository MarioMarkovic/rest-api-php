<?php 

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
	
require_once(realpath(dirname(__FILE__) . '/../../app/config/DB.php'));
require_once(realpath(dirname(__FILE__) . '/../../app/models/Category.php'));

$data = json_decode(file_get_contents("php://input"));

if(!empty($data)) {

	$params = [
		":id" => htmlspecialchars(strip_tags($data->id)),
		":name" => htmlspecialchars(strip_tags($data->name))
	];

	$update = DB::connection()->update("UPDATE categories SET name=:name WHERE id=:id", $params);

	if($update) {
		echo json_encode(['message' => "Category updated", 'Name' => $data->name ]);
	} else {
		echo json_encode(['message' => "Category not updated"]);
	}

} else {
	die();
}



