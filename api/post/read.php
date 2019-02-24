<?php 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once(realpath(dirname(__FILE__) . '/../../app/config/DB.php'));
require_once(realpath(dirname(__FILE__) . '/../../app/models/Post.php'));

$posts = DB::connection()->select("SELECT p.id, p.category_id, p.title, p.body, p.author, p.created_at, c.name FROM posts p LEFT JOIN categories c ON p.category_id=c.id");

$arrPosts = [];
if($posts->getCount() > 0) {
	foreach($posts->getResults() as $post) {
		$arrPosts[] = new Post($post->id, $post->category_id, $post->title, $post->body, $post->author, $post->name, $post->created_at);
	}
	$data = [];
	foreach($arrPosts as $post) {
		array_push($data, [
			'id' 			=> $post->getId(),
			'category_id' 	=> $post->getCategoryId(),
			'category_name'	=> $post->getName(),
			'title' 		=> $post->getTitle(),
			'body' 			=> $post->getBody(),
			'author' 		=> $post->getAuthor(),
			'created_at' 	=> $post->getCreatedAt(),
		]);
	}

	echo json_encode(($data));

} else {
	echo json_encode(['message' => "No posts found"]);
}

