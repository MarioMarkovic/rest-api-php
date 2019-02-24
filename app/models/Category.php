<?php 
require_once(realpath(dirname(__FILE__) . '/Model.php'));

class Category extends Model
{

	public function __construct($id, $name, $created_at = "")
	{
		parent::__construct($id, $name, $created_at);
	}
}