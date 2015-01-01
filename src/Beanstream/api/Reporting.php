<?php 	namespace Beanstream;


/**
 * Reporting class to handle reports generation
 *  
 * @author Kevin Saliba
 */
class Reporting {
	
	protected $_auth;
	
	protected $_endpoint;
	
	protected $_config;
	
	protected $_connector;
	
	function __construct(Configuration $config) {
		
		//get/set config
		$this->_config = $config;
		
		//get encoded payments auth 
		$this->_auth = base64_encode($this->_config->getMerchantId().':'.$this->_config->getApiKey('reporting'));
		
		//init endpoint
		$this->_endpoint = new Endpoints($this->_config->getPlatform(), $this->_config->getApiVersion());
		
		//init http connector
		$this->_connector = new HttpConnector($this->_auth);
		
	}
	
	
	
	//get transactions based on criteria
	public function getTransactions($data) {
		        
		//get reporting endpoint
		$endpoint =  $this->_endpoint->getReportingURL();
		
		//process as is
		$result = $this->_connector->processTransaction('POST', $endpoint, $data);

		//send back the result
        return $result;
		
	}
	
	
	
	//get a single transaction via 'Search'
	//TODO not exactly working, returning call help desk, but all is ok
	public function getTransaction($transaction_id = '') {
		        
		//get reporting endpoint
		$endpoint =  $this->_endpoint->getPaymentUrl($transaction_id);

		//print_r($endpoint);die();
				
		//process as is
		$result = $this->_connector->processTransaction('GET', $endpoint, NULL);


		//send back the result
        return $result;
		
	}
	
	
	
	
	
}