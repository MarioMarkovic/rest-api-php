<?php 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

if(isset($_GET['id']) && !empty(trim($_GET['id'])) && is_numeric($_GET['id'])) {
	
	require_once(realpath(dirname(__FILE__) . '/../../app/config/DB.php'));
	require_once(realpath(dirname(__FILE__) . '/../../app/models/Post.php'));

	$postId = $_GET['id'];

	$getPost = DB::connection()->selectOne("SELECT p.id, p.category_id, p.title, p.body, p.author, p.created_at, c.name FROM posts p LEFT JOIN categories c ON p.category_id=c.id WHERE p.id=:id", [':id' => $postId])->getResult();

	if($getPost) {
		$post = new Post($getPost->id, $getPost->category_id, $getPost->title, $getPost->body, $getPost->author, $getPost->name, $getPost->created_at);

		$data = [
			'id' 			=> $post->getId(),
			'category_id' 	=> $post->getCategoryId(),
			'category_name'	=> $post->getName(),
			'title' 		=> $post->getTitle(),
			'body' 			=> $post->getBody(),
			'author' 		=> $post->getAuthor(),
			'created_at' 	=> $post->getCreatedAt(),
		];

		echo json_encode(($data));
		
	} else {
		echo json_encode(['message' => "No posts found"]);
	}
	
} else {
	die();
}


