<?php 	namespace Beanstream;


/**
 * Profiles class to handle profile and card actions
 *  
 * @author Kevin Saliba
 */
class Profiles {
	
    /**
     * Base64 Encoded Auth String for Profiles API
     * 
     * @var string $_auth
     */
	protected $_auth;

    /**
     * Built Profiles Endpoint 
     * 
     * @var string $_endpoint
     */	
	protected $_endpoint;

	/**
     * Config object
	 * 
	 * Holds mid, apikeys[], platform, api version
     * 
     * @var	\Beanstream\Configuration	$_config
     */
	protected $_config;

	/**
     * HttpConnector object
	 * 
     * @var	\Beanstream\HttpConnector	$_connector
     */	
	protected $_connector;
	
	
    /**
     * Constructor
     * 
	 * Inits the appropriate endpoint and httpconnector objects 
	 * Sets all of the Profiles class properties
	 * 
     * @param \Beanstream\Configuration $config
     */	
	function __construct(Configuration $config) {
		
		//get/set config
		$this->_config = $config;
		
		//get encoded profiles auth 
		$this->_auth = base64_encode($this->_config->getMerchantId().':'.$this->_config->getApiKey('profiles'));
		
		//init endpoint
		$this->_endpoint = new Endpoints($this->_config->getPlatform(), $this->_config->getApiVersion());
		
		//init http connector
		$this->_connector = new HttpConnector($this->_auth);
		
	}

	
    /**
     * createProfile() function - Create a new profile
     * @link http://developer.beanstream.com/documentation/tokenize-payments/create-new-profile/
     * 
     * @param array $data Profile data
     * @return string Profile Id (aka customer_code)
     */
	public function createProfile($data = NULL) {
        
		//get profiles endpoint
		$endpoint =  $this->_endpoint->getProfilesURL();
		
		//process as is
		$result = $this->_connector->processTransaction('POST', $endpoint, $data);

		//send back the new customer code
        return $result['customer_code'];
    }
	
    /**
     * getProfile() function - Retrieve a profile
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
        
		//unset($result['code'], $result['message']); //not sure why this was being done.. why not give it all back?
		
        return $result;
    }
	
    /**
     * updateProfile() function - Update a profile via PUT
     * @link http://developer.beanstream.com/documentation/tokenize-payments/update-profile/
     * 
     * @param string $profile_id Profile Id
     * @param array $data Profile data
     * @return bool TRUE
     */
    public function updateProfile($profile_id, $data = NULL) {
    	
		//get this profile's endpoint
		$endpoint =  $this->_endpoint->getProfileURI($profile_id);
				
		//process as PUT
		$result = $this->_connector->processTransaction('PUT', $endpoint, $data);
		
        return TRUE;
    }
	
    /**
     * deleteProfile() function - Delete a profile via DELETE http method
     * @link http://developer.beanstream.com/documentation/tokenize-payments/delete-profile/
     * 
     * @param string $profile_id Profile Id
     * @return bool TRUE
     */
    public function deleteProfile($profile_id) {
    	
		//get this profile's endpoint
		$endpoint =  $this->_endpoint->getProfileURI($profile_id);
				
		//process as DELETE
		$result = $this->_connector->processTransaction('DELETE', $endpoint, NULL);
		
        return TRUE;
    }
	
    /**
     * getCards() function - Retrieve all cards in a profile
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
		
		//return cards
        return $result;
    }

    /**
     * addCard() function - Add a card to a profile
     * @link http://developer.beanstream.com/documentation/tokenize-payments/add-card-profile/
     * 
     * @param string $profile_id Profile Id
     * @param array $data Card data
     * @return bool TRUE see note below
     */
    public function addCard($profile_id, $data)
    {
		
		//get profiles cards endpoint
		$endpoint =  $this->_endpoint->getCardsURI($profile_id);
		
		//process as is
		$result = $this->_connector->processTransaction('POST', $endpoint, $data);
		
        /*
         * XXX it would be more appropriate to return newly added card_id,
         * but API does not return it in result
         */
        return TRUE;
    }
	
    /**
     * updateCard() function - Update a single card in a profile
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
     * deleteCard() function - Delete a card from a profile via DELETE http method
     * @link http://developer.beanstream.com/documentation/tokenize-payments/delete-card-profile/
     * 
     * @param string $profile_id Profile Id
     * @param string $card_id Card Id
     * @return bool TRUE
     */
    public function deleteCard($profile_id, $card_id) {
    	
		//get this card's endpoint
		$endpoint =  $this->_endpoint->getCardURI($profile_id, $card_id);
				
		//process as DELETE
		$result = $this->_connector->processTransaction('DELETE', $endpoint, NULL);
		
        return TRUE;
    }
	
}