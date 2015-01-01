<?php
namespace Beanstream;

/**
 * Beanstream specific exception type
 * 
 * Zero error code corresponds to PHP API specific errors
 * 
 * Positive error codes correspond to those of Beanstream API
 * @link http://developer.beanstream.com/documentation/analyze-payments/api-messages/
 * 
 * Negative error codes corresponde to those of cURL
 * @link http://curl.haxx.se/libcurl/c/libcurl-errors.html
 * 
 * @author Kevin Saliba
 */
class Exception extends \Exception {
	
	protected $_code;
	protected $_message;
	
	
	public function __construct($message, $code = 0) {
		
		$this->_message = $message;
		$this->_code = $code;
		
		//echo $this->__toString();
		
		parent::__construct($this->_message, $this->_code);
		
		
		
	}


	
	
}



class ConfigurationException extends Exception {}

class ConnectorException extends Exception {}

class ApiException extends Exception {
	
	public function __construct($message, $code = 0) {
		
		echo 'Api Exception: Code: '.$code.'; Message: \''.$message.'\'';
		die();
		
	}
	
	
}
