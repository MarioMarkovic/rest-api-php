<?php 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once(realpath(dirname(__FILE__) . '/../../app/config/DB.php'));
require_once(realpath(dirname(__FILE__) . '/../../app/models/Category.php'));

$categories = DB::connection()->select("SELECT id, name, created_at FROM categories");

$arrCategories = [];
if($categories->getCount() > 0) {
	foreach($categories->getResults() as $category) {
		$arrCategories[] = new Category($category->id, $category->name, $category->created_at);
	}
	$data = [];
	foreach($arrCategories as $category) {
		array_push($data, [
			'id' 		=> $category->getId(),
			'name'		=> $category->getName(),
			'created_at'=> $category->getCreatedAt(),
		]);
	}

	echo json_encode(($data));

} else {
	echo json_encode(['message' => "No categories found"]);
}

