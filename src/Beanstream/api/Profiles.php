<?php 	namespace Beanstream;


/**
 * Profiles class to handle profile and card actions
 *  
 * @author Kevin Saliba
 */
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
        return $result;//['customer_code'];
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
		
		//process as is
		$result = $this->_connector->processTransaction('GET', $endpoint, NULL);
        
		//unset($result['code'], $result['message']); //not sure why this was being done.. why not give it all back
		
        return $result;
    }
    
	
    /**
     * Update a profile via PUT
     * @link http://developer.beanstream.com/documentation/tokenize-payments/update-profile/
     * 
     * @param string $pid Profile Id
     * @param array $data Profile data
     * @return TRUE
     */
    public function updateProfile($profile_id, $data = NULL) {
    	

		//get this profile's endpoint
		$endpoint =  $this->_endpoint->getProfileURI($profile_id);
				
		//process as PUT
		$result = $this->_connector->processTransaction('PUT', $endpoint, $data);
		
        return true;
    }
    	
	
    /**
     * Delete a profile via DELETE http method
     * @link http://developer.beanstream.com/documentation/tokenize-payments/delete-profile/
     * 
     * @param string $profile_id Profile Id
     * @return TRUE
     */
    public function deleteProfile($profile_id) {
    	
		//get this profile's endpoint
		$endpoint =  $this->_endpoint->getProfileURI($profile_id);
				
		//process as DELETE
		$result = $this->_connector->processTransaction('DELETE', $endpoint, NULL);
		
        return true;
    }
    
	
	
	
	
    /**
     * Retrieve all cards in a profile
     * @link http://developer.beanstream.com/documentation/tokenize-payments/retrieve-cards-profile/
     * 
     * @param string $profile_id Profile Id
     * @return array Cards data
     */
    public function getCards($profile_id) {

		//get this profile's cards endpoint
		$endpoint =  $this->_endpoint->getCardsURI($profile_id);
		
		//process as is
		$result = $this->_connector->processTransaction('GET', $endpoint, NULL);
		
        return $result;
    }
    
	

    /**
     * Add card to a profile
     * @link http://developer.beanstream.com/documentation/tokenize-payments/add-card-profile/
     * 
     * @param string $profile_id Profile Id
     * @param array $data Card data
     * @return TRUE
     */
    public function addCard($profile_id, $data)
    {
		
		//get profiles cards endpoint
		$endpoint =  $this->_endpoint->getCardsURI($profile_id);
		
		//process as is
		$result = $this->_connector->processTransaction('POST', $endpoint, $data);
		
		return $result;
		
        /*
         * XXX it would be more appropriate to return newly added card id,
         * but Beanstream for some reason does not return it in result
         */
        //return true;
    }
    	
	
	
    /**
     * Update a single card in a profile
     * @link http://developer.beanstream.com/documentation/tokenize-payments/update-card-profile/
     * 
     * @param string $profile_id Profile Id
     * @param string $card_id Card Id
     * @return array Result
     */
    public function updateCard($profile_id, $card_id, $data) {

		//get this card's endpoint
		$endpoint =  $this->_endpoint->getCardURI($profile_id, $card_id);
		
		//process as is
		$result = $this->_connector->processTransaction('PUT', $endpoint, $data);
		
        return $result;
    }
    
	
		
    /**
     * Delete a card from a profile via DELETE http method
     * @link http://developer.beanstream.com/documentation/tokenize-payments/delete-card-profile/
     * 
     * @param string $profile_id Profile Id
     * @param string $card_id Card Id
     * @return TRUE
     */
    public function deleteCard($profile_id, $card_id) {
    	
		//get this card's endpoint
		$endpoint =  $this->_endpoint->getCardURI($profile_id, $card_id);
				
		//process as DELETE
		$result = $this->_connector->processTransaction('DELETE', $endpoint, NULL);
		
        return true;
    }
    
	
	
	
	
	
	
	
	
}