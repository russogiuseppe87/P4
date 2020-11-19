<?php
namespace Blog;
  /**
    * class Autoloader
  */
class Autoloader{

  /**
    * enregistre notre autoloader
  */
	static function register(){
  		spl_autoload_register(array(__CLASS__,'autoload'));
  	}

    /**
      * inclue le fichier correspondant à notre classe
      * @param $class string le nom de la classe à charger
    */
  	static function autoload($class){

  		if (strpos($class, __NAMESPACE__ . '\\') === 0){

	  		$class = str_replace (__NAMESPACE__ . '\\', '', $class);

	  		$class = str_replace ('\\', '/', $class);

	  		require __DIR__ . '/' . $class . '.php';

  		}
  	}

}