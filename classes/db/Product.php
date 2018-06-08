<?php

Class Product extends Model {

	public $id;
	public $title;
	public $image;
	public $description;
	public $created_at;
	public $updated_at;


	public function shortDescription()
	{
		if(strlen($this->description) > 150) {
			return substr($this->description, 0, 150).'...</p>';
		}
		return $this->description;
	}


}
