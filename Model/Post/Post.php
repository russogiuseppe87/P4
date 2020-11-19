<?php

namespace Blog\Model\Post; 

class Post{

	private $_id;
	private $_author;
	private $_title;
	private $_content;
	private $_extract;
	private $_creation_date_fr;
	private $_first = false;
	private $_last = false;

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

	// Liste des getters

	public function id(){
		return $this->_id;
	}
	public function author(){
		return $this->_author;
	}
	public function title(){
		return $this->_title;
	}
	public function content(){
		return $this->_content;
	}
	public function extract(){
		return $this->_extract;
	}
	public function creation_date_fr(){
		return $this->_creation_date_fr;
	}
	public function first(){
		return $this->_first;
	}
	public function last(){
		return $this->_last;
	}

	// Liste des setters

	public function setId($id){
		// On convertit l'argument en nombre entier.
    	$id = (int) $id;
	    // On vérifie ensuite si ce nombre est bien strictement positif.
	    if ($id > 0){
	        $this->_id = $id;
    	}
	}
	public function setAuthor($author){
	    if (is_string($author)){
	      $this->_author = $author;
	    }
	}
	public function setTitle($title){
	    // On vérifie qu'il s'agit bien d'une chaîne de caractères.
	    if (is_string($title)){
	      $this->_title = $title;
	    }
	}
	public function setContent($content){
	    if (is_string($content)){
	      $this->_content = $content;
	    }
	}
	public function setExtract($extract){
		if (is_string($extract)){
	      $this->_extract = $extract;
	    }
	}
	public function setCreation_date_fr($creation_date_fr){
		$this->_creation_date_fr = $creation_date_fr;
	}
	public function setFirst(){
		$this->_first = true;
	}
	public function setLast(){
		$this->_last = true;
	}
	
}