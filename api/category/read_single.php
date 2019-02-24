<?php 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

if(isset($_GET['id']) && !empty(trim($_GET['id'])) && is_numeric($_GET['id'])) {
	
	require_once(realpath(dirname(__FILE__) . '/../../app/config/DB.php'));
	require_once(realpath(dirname(__FILE__) . '/../../app/models/Category.php'));

	$categoryId = $_GET['id'];

	$getCategory = DB::connection()->selectOne("SELECT id, name, created_at FROM categories WHERE id=:id", [':id' => $categoryId])->getResult();

	if($getCategory) {
		$category = new Category($getCategory->id, $getCategory->name, $getCategory->created_at);

		$data = [
			'id' 		 => $category->getId(),
			'name'		 => $category->getName(),
			'created_at' => $category->getCreatedAt(),
		];

		echo json_encode(($data));
		
	} else {
		echo json_encode(['message' => "No categories found"]);
	}
	
} else {
	die();
}


