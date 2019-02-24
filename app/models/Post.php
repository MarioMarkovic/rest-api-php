<?php 
require_once(realpath(dirname(__FILE__) . '/Model.php'));

class Post extends Model
{
	private $category_id;
	private $title;
	private $body;
	private $author;

	public function __construct($id, $category_id, $title, $body, $author, $name, $created_at = "")
	{
		parent::__construct($id, $name, $created_at);
		
		$this->category_id = $category_id;
		$this->title = $title;
		$this->body = $body;
		$this->author = $author;
	}

	public function getCategoryId()
	{
		return $this->category_id;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function getBody()
	{
		return $this->body;
	}

	public function getAuthor()
	{
		return $this->author;
	}

}