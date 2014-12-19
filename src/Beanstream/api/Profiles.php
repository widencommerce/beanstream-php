<?php 	namespace Beanstream;



class Profiles {
	
	protected $_auth;
	
	protected $_endpoint;
	
	protected $_config;
	
	protected $_connector;
	
	function __construct(Configuration $config) {
		
		//get/set config
		$this->_config = $config;
		
		//get encoded payments auth 
		$this->_auth = base64_encode($this->_config->getMerchantId().':'.$this->_config->getApiKey('profiles'));
		
		//init endpoint
		$this->_endpoint = new Endpoints($this->_config->getPlatform(), $this->_config->getApiVersion());
		
		//init http connector
		$this->_connector = new HttpConnector($this->_auth);
		
	}
	
	
	
	
	
	
    /**
     * Create a new profile
     * @link http://developer.beanstream.com/documentation/tokenize-payments/create-new-profile/
     * 
     * @param array $data Profile data
     * @return string Profile Id (aka customer_code)
     */
    public function createProfile($data = NULL)
    {
        
		//get profiles endpoint
		$endpoint =  $this->_endpoint->getProfilesURL();
		
		
		//process as is
		$result = $this->_connector->processTransaction('POST', $endpoint, $data);



		//send back the new customer code
        return $result['customer_code'];
    }
    
	
	
	
    /**
     * Retrieve a profile
     * @link http://developer.beanstream.com/documentation/tokenize-payments/retrieve-profile/
     * 
     * @param string $profile_id Profile Id
     * @return array Profile data
     */
    public function getProfile($profile_id) {

		//get this profile's endpoint
		$endpoint =  $this->_endpoint->getProfileURI($profile_id);
		
 		//   unset($res['code'], $res['message']);
		
		//process as is
		$result = $this->_connector->processTransaction('POST', $endpoint, $data);
        
        return $result;
    }
    
	
	
	
	
	
	
	
}