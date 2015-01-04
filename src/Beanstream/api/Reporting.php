<?php 	namespace Beanstream;


/**
 * Reporting class to handle reports generation
 *  
 * @author Kevin Saliba
 */
class Reporting {
	
    /**
     * Base64 Encoded Auth String for Reporting API
     * 
     * @var string $_auth
     */
	protected $_auth;

    /**
     * Built Reporting Endpoint 
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
	 * Sets all of the Reporting class properties
	 * 
     * @param \Beanstream\Configuration $config
     */
	function __construct(Configuration $config) {
		
		//get/set config
		$this->_config = $config;
		
		//get encoded reporting auth 
		$this->_auth = base64_encode($this->_config->getMerchantId().':'.$this->_config->getApiKey('reporting'));
		
		//init endpoint
		$this->_endpoint = new Endpoints($this->_config->getPlatform(), $this->_config->getApiVersion());
		
		//init http connector
		$this->_connector = new HttpConnector($this->_auth);
		
	}
	
	
	//
    /**
     * getTransactions() function - Get transactions result array based on search criteria
     * @link http://developer.beanstream.com/analyze-payments/search-specific-criteria/
     * 
     * @param array $data search criteria
     * @return array Result Transactions
     */
	public function getTransactions($data) {
		        
		//get reporting endpoint
		$endpoint =  $this->_endpoint->getReportingURL();
		
		//process as is
		$result = $this->_connector->processTransaction('POST', $endpoint, $data);

		//send back the result
        return $result;
	}
	
    /**
     * getTransaction() function - get a single transaction via 'Search'
	 * 	//TODO not exactly working, returning call help desk, but incoming payload seems ok
     * @link http://developer.beanstream.com/documentation/analyze-payments/
     * 
     * @param string $transaction_id Transaction Id
     * @return array Transaction data
     */	
	public function getTransaction($transaction_id = '') {
		        
		//get reporting endpoint
		$endpoint =  $this->_endpoint->getPaymentUrl($transaction_id);

		//DEBUG
		//print_r($endpoint);die();
				
		//process as is
		$result = $this->_connector->processTransaction('GET', $endpoint, NULL);

		//send back the result
        return $result;
		
	}
	
}