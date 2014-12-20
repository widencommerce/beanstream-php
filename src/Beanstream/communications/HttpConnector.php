<?php 	namespace Beanstream;

class HttpConnector {
	
	protected $_auth;
	
	
	
	function __construct($auth) {
		$this->_auth = $auth;
	}
	
	
	public function processTransaction($http_method, $endpoint, $data) {
		
		return $this->request($endpoint, $http_method, $data);
		
			
	}
	
	
	
	
	
    /**
     * Send request to a gateway.
     * 
     * This is a generic method, in most cases a specific
     * one should be used, e.g. Messenger::createProfile()
     * 
     * @param string $url incoming endpoint 
     * @param array[optional] $data Data to user with POST request, if not set GET request is used
     * @param string[optional] $method HTTP method to use, by default is GET if there is no $data and PUT when there is $data set
     * @return array Decoded API response
     */
    private function request($url, $http_method = NULL, $data = NULL)
    {
    	//check to see if we have curl installed on the server 
        if ( ! extension_loaded('curl')) {
        	//no curl
            throw new Exception('The curl extension is required', 0);
        }
        
		//init the curl request
		//via endpoint to curl
        $req = curl_init($url);
        
		//set request headers with encoded auth
        curl_setopt($req, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Passcode '.$this->_auth,
        ));
		
		//set other curl options        
        curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($req, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($req, CURLOPT_TIMEOUT, 30);
        
		//test ssl3 (remember to set platform)
		//curl_setopt($req, CURLOPT_SSLVERSION, 3);
		
		
		//set http method
        if (is_null($http_method)) {
            if (is_null($data)) {
                $http_method = 'GET';
            } else {
                $http_method = 'POST';
            }
        }
		
		//set http method
        curl_setopt($req, CURLOPT_CUSTOMREQUEST, $http_method);
        
		//make sure incoming payload is good to go, set it
        if ( ! is_null($data)) {
            curl_setopt($req, CURLOPT_POSTFIELDS, json_encode($data));
        }
        
		//execute curl request
        $raw = curl_exec($req);
        if (false === $raw) { //make sure we got something back
            throw new Exception(curl_error($req), -curl_errno($req));
        }
        
		//decode the result
        $res = json_decode($raw, true);
        if (is_null($res)) { //make sure the result is good to go
            throw new Exception('Unexpected response format', 0);
        }
        
		//check for return errors from the API
        if (isset($res['code']) and 1 < $res['code']) {
			//return errors found
            //
            //TODO i don't like this, i'd rather return the raw error
            //throw new Exception($res['message'], $res['code']);
        }
        
        return $res;
    }	
	
	
}
