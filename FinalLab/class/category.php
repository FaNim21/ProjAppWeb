<?php

class Category
{
	//autoincrement
	private $id;
	private $parent;
	private $category_name;

	//To check if changes in object was made.
	private $hash;

	public function __construct()
	{
		$this->hash = $this->getHash();
	}

	function add()
	{
		return 'INSERT INTO categories (category_name, parent) VALUES (\'' .$this->category_name. '\',' .$this->parent. ')';
	}

	function edit()
	{
		return 'UPDATE categories SET category_name=\'' .$this->category_name. '\', parent=' .$this->parent. ' WHERE id=' .$this->id;
	}

	function delete()
	{
		return 'DELETE FROM categories WHERE id=' .$this->id;
	}

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param mixed $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @return mixed
	 */
	public function getParent()
	{
		return $this->parent;
	}

	/**
	 * @param mixed $parent
	 */
	public function setParent($parent)
	{
		$this->parent = $parent;
	}

	/**
	 * @return mixed
	 */
	public function getCategoryName()
	{
		return $this->category_name;
	}

	/**
	 * @param mixed $category_name
	 */
	public function setCategoryName($category_name)
	{
		$this->category_name = $category_name;
	}

	private function getHash()
	{
		$sum = (string)$this->id . (string)$this->parent . $this->category_name;
		return hash("sha512", $sum);
	}

	//check if changes was made in object after creation
	public function changed(){
		if(empty($this->id)){
			return false; //nothing in DB
		} else {
			if($this->hash !== $this->getHash()){
				return true;
			}
			return false;
		}
	}

}