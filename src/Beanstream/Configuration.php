<?php	namespace Beanstream;

/**
 * Configuration class to handle merchant id, api keys, platform & version defaults 
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
     * @var int $_merchantId
     */
	protected $_merchantId;


    /**
     * Configuration: API Key
     * 
     * @var array $_apiKeys
     */
	protected $_apiKeys;





	public function setMerchantId($merchantId = '') {
		if (strlen($merchantId) !== 9) { //switch to actual real assertmerchantId
			//throw exception
			
		}
		$this->_merchantId = $merchantId;
	}

	public function getMerchantId() {
		return $this->_merchantId;
	}



	public function setApiKeys($apiKeys = '') {
		$this->_apiKeys=$apiKeys;
	}
	public function getApiKey($key) {
		return $this->_apiKeys[$key];
	}




	public function setPlatform($platform = '') {
		if (strlen($platform) > 0) { //switch to actual real assertnotempty
			$this->_platform=$platform;
		}
	}
	public function getPlatform() {
		return $this->_platform;
	}	
	
	

	public function setApiVersion($version = '') {
		if (strlen($version) > 0) { //switch to actual real assertnotempty
			$this->_version=$version;
		}
	}
	public function getApiVersion() {
		return $this->_version;
	}	
}

