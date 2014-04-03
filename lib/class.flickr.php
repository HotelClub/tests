<?php
#==========================================================================================
# File: class.flicket.php
# Created Date: 02-Apr-2012
# Developer: Santosh Hegde
# Purpose: To declare a class and methods to work with flickr api
#==========================================================================================

# create a class 'flickr'
class Flickr{
	
	# declare member variables
	private $apiKey;
	private $serviceRestUrl = 'https://api.flickr.com/services/rest';
	private static $instance;
	
	# declare constructor
	function __construct($key = false) {
		if ($key) $this->setKey ( $key );
	}
	
	# create flickr instanace if not already exists
	public static function load($key = false){
		if (is_object ( self::$instance ))
			$obj = $instance;
		else
			$obj = new flickr();
		
		if ($key)
			$obj->setKey($key);
		return $obj;
	}
	
	# to send request with proper user's requirements (search keywords)
	public function request($params) {			
		$result = @file_get_contents ($this->serviceRestUrl.'/?api_key='. $this->apiKey .'&'. $this->encodeParam($params));
		
		if ($params['format'] == 'php_serial')
			return $this->searialParser($result);
		
		elseif ($params['format'] == 'json')
			return $this->jsonParser($result);		
	}
	
	# encode request before sending it to flickr
	public function encodeParam($params){
		$encoded_params = array();
		foreach ( $params as $k => $v ) {
			$encoded_params [] = urlencode ( $k ) . '=' . urlencode ( $v );
		}		
		return implode ('&',$encoded_params);
	}
	
	# set flickr api key
	public function setKey($key){
		$this->apiKey = $key;
	}
	
	# get flickr api key
	public function getKey(){
		return $this->apiKey;
	}
	
	# parser the result
	public function searialParser($result){
		return unserialize($result);
	}
	
	# parser the result in json
	public function jsonParser($result){
		return json_decode($result);
	}
}
