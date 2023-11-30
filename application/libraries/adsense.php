<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Adsense {

	public function __construct()
    {
		
    }
    public function getFun($class_name='')
    {
    	if(!empty($class_name)) {
    		include 'examples/' . $class_name . '.php';
    	}
    }
}