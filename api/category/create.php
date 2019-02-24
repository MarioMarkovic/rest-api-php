<?php 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
	
require_once(realpath(dirname(__FILE__) . '/../../app/config/DB.php'));
require_once(realpath(dirname(__FILE__) . '/../../app/models/Category.php'));

$data = json_decode(file_get_contents("php://input"));

if(!empty($data)) {

	$params = [
		":name" => htmlspecialchars(strip_tags($data->name)), 
	];

	$insert = DB::connection()->insert("INSERT INTO categories SET name=:name", $params);

	if($insert) {
		echo json_encode(['message' => "Category created", 'Id' => $insert->getLastInsertedId() ]);
	} else {
		echo json_encode(['message' => "Category not created"]);
	}

} else {
	die();
}



