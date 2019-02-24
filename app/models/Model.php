<?php 

class Model 
{
	private $id;
	private $created_at;
	private $name;

	public function __construct($id, $name, $created_at = "")
	{
		$this->id = $id;
		$this->created_at = $created_at;
		$this->name = $name;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getCreatedAt()
	{
		return $this->created_at;
	}

	public function getName()
	{
		return $this->name;
	}
}