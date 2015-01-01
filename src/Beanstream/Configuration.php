<?php	namespace Beanstream;

/**
 * Configuration class to handle merchant id, api keys, platform & version 
 *  
 * @author Kevin Saliba
 */
class Configuration {

    /**
     * Configuration: API Version
     * 
     * @var string $_version
     */
	protected $_version = 'v1'; //default

    /**
     * Configuration: API Platform
     * 
     * @var string $_platform
     */
	protected $_platform = 'www'; //default


    /**
     * Configuration: Merchant ID
     * 
     * @var string $_merchantId
     */
	protected $_merchantId;


    /**
     * Configuration: API Keys
     * 
     * @var string[] $_apiKeys
     */
	protected $_apiKeys;




	/**
	 * setMerchantId() function
	 *
	 * @param string $merchantId
	 * @return void
	 */
	public function setMerchantId($merchantId = '') {
		//check to make sure we have a 9 digit string containing only digits 0-9
		if (!preg_match('/^[0-9]{9}$/', $merchantId)) { //TODO switch to actual real assertmerchantId
			//throw exception
			throw new ConfigurationException('Invalid Merchant ID provided: '.$merchantId. ' Expected 9 digits.');
		}
		$this->_merchantId = $merchantId;
	}

	/**
	 * getMerchantId() function
	 *
	 * @return string merchant id
	 */
	public function getMerchantId() {
		return $this->_merchantId;
	}


	/**
	 * setApiKeys() function
	 * 
	 * Takes in an array of keys 'payments', 'profiles', 'reporting'
	 * and string values for each key. Not every key is needed, only
	 * those being used/set in Beanstream Dashboard > Order Settings.
	 *
	 * @param string[] $apiKeys
	 * @return void
	 */
	public function setApiKeys($apiKeys = array()) {
		$this->_apiKeys=$apiKeys;
	}
	/**
	 * getApiKey() function
	 *
	 * @param string $key which key to return: 'payments', 'profiles', 'reporting' 
	 * @return string api key
	 */
	public function getApiKey($key) {
		return $this->_apiKeys[$key];
	}



	/**
	 * setPlatform() function
	 * 
	 * @param string[] $platform
	 * @return void
	 */
	public function setPlatform($platform = '') {
		//make sure it's not blank
		//if blank, don't set it and use default declared above
				if (strlen($platform) > 0) { //TODO switch to actual real assertnotempty
			$this->_platform=$platform;
		}
	}
	
	/**
	 * getPlatform() function
	 *
	 * @return string platform
	 */
	public function getPlatform() {
		return $this->_platform;
	}	
	
	
	/**
	 * setApiVersion() function
	 * 
	 * @param string[] $version
	 * @return void
	 */
	public function setApiVersion($version = '') {
		//make sure it's not blank
		//if blank, don't set it and use default declared above
		if (strlen($version) > 0) { //TODO switch to actual real assertnotempty
			$this->_version=$version;
		}
	}

	/**
	 * getApiVersion() function
	 *
	 * @return string version
	 */
	public function getApiVersion() {
		return $this->_version;
	}	
	
	
	
	
	
}

