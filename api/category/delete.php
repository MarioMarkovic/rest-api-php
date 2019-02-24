<?php 

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
	
require_once(realpath(dirname(__FILE__) . '/../../app/config/DB.php'));
require_once(realpath(dirname(__FILE__) . '/../../app/models/Category.php'));

$data = json_decode(file_get_contents("php://input"));

if(!empty(trim($data->id)) && is_numeric($data->id)) {

	$params = [
		":id" => htmlspecialchars(strip_tags($data->id))
	];

	$delete = DB::connection()->delete("DELETE FROM categories WHERE id=:id", $params);

	if($delete) {
		echo json_encode(['message' => "Category deleted", 'Id' => $data->id ]);
	} else {
		echo json_encode(['message' => "Category not deleted"]);
	}

} else {
	die();
}



