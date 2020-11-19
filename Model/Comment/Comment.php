<?php

namespace Blog\Model\Comment; 

class Comment{

	private $_id;
	private $_post_id;
	private $_author;
	private $_content;
	private $_creation_date_fr;
	private $_reported;


	public function __construct(array $donnees){

	    $this->hydrate($donnees);
	}

	private function hydrate(array $donnees){
	
		foreach ($donnees as $key => $value){
	      	$method = 'set'.ucfirst($key);

	      	if(method_exists($this, $method)){
	      		$this->$method($value);
	      	}
	    }
	}


	public function id(){
		return $this->_id;
	}
	public function post_id(){
		return $this->_post_id;
	}
	public function author(){
		return $this->_author;
	}
	public function content(){
		return $this->_content;
	}
	public function creation_date_fr(){
		return $this->_creation_date_fr;
	}
	public function reported(){
		return $this->_reported;
	}


	public function setId($id){
		// On convertit l'argument en nombre entier.
		$id = (int) $id;
		// On vérifie ensuite si ce nombre est bien strictement positif.
		if ($id > 0){
			$this->_id = $id;
		}
	}
	public function setPost_id($post_id){
		$post_id = (int) $post_id;
		if ($post_id > 0){
			$this->_post_id = $post_id;
		}
	}
	public function setAuthor($author){
		// On vérifie qu'il s'agit bien d'une chaîne de caractères.
		if (is_string($author)){
	      	$this->_author = $author;
	    }
	}
	public function setContent($content){
		if (is_string($content)){
	      	$this->_content = $content;
	    }
	}
	public function setCreation_date_fr($creation_date_fr){
		$this->_creation_date_fr = $creation_date_fr;
	}
	public function setReported($reported){
		$reported = (int) $reported;
		if ($reported < 2){
			$this->_reported = $reported;
		}
	}

}