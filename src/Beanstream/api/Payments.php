<?php 	namespace Beanstream;


/**
 * Payments class to handle payment actions,
 *  
 * @author Kevin Saliba
 */
class Payments {
	
	protected $_auth;
	
	protected $_endpoint;
	
	protected $_config;
	
	protected $_connector;
	
	function __construct(Configuration $config) {
		
		//get/set config
		$this->_config = $config;
		
		//get encoded payments auth 
		$this->_auth = base64_encode($this->_config->getMerchantId().':'.$this->_config->getApiKeys('payments'));
		
		//init endpoint
		$this->_endpoint = new Endpoints($this->_config->getPlatform(), $this->_config->getApiVersion());
		
		//init http connector
		$this->_connector = new HttpConnector($this->_auth);
		
	}
	
	
	//generic payment
	public function makePayment($data = NULL) {
		$endpoint =  $this->_endpoint->getBasePaymentsURL();
		
		//process as is
		return $this->_connector->processTransaction('POST', $endpoint, $data);
		
	}
	
	
	public function makeCardPayment($data = NULL, $complete = TRUE) {
		$endpoint =  $this->_endpoint->getBasePaymentsURL();
//		$endpoint = $this->_endpoint->getPaymentUrl($this->_config->getPlatform(),$this->_config->getApiVersion(), $paymentId);
		
		//force card
		$data['payment_method'] = 'card';
		$data['card']['complete'] = (is_bool($complete) === TRUE ? $complete : TRUE);
		return $this->_connector->processTransaction('POST', $endpoint, $data);
	
		
	}
	
    /**
     * Pre-authorization completion
     * @link http://developer.beanstream.com/documentation/take-payments/pre-authorization-completion/
     * 
     * @param string $oid Transaction Id
     * @param mixed $amount Order amount
     * @param string[optional] $order_number
     * @return array Transaction details
     */
    public function complete($transaction_id, $amount, $order_number = NULL) {
    	
		//get endpoint
		$endpoint =  $this->_endpoint->getPreAuthCompletionsURL($transaction_id);

		$data['card']['complete'] = TRUE;
        $data['amount'] = $amount;
        if ( ! is_null($order_number)) {
            $data['order_number'] = $order_number;
        }
	
		//print_r($endpoint); die();

		return $this->_connector->processTransaction('POST', $endpoint, $data);

    }
    	
	
	
	
	
	
	
	public function makeCashPayment($data = NULL) {
		$endpoint =  $this->_endpoint->getBasePaymentsURL();
		
		//force cash
		$data['payment_method'] = 'cash';
		return $this->_connector->processTransaction('POST', $endpoint, $data);
	
		
	}	
	
	
	
	public function makeChequePayment($data = NULL) {
		$endpoint =  $this->_endpoint->getBasePaymentsURL();
		
		//force chq
		$data['payment_method'] = 'cheque';
		return $this->_connector->processTransaction('POST', $endpoint, $data);
	
		
	}	
	
	
	
	
    /**
     * Return (can't use reserved 'return' keyword for method name)
     * @link http://developer.beanstream.com/documentation/take-payments/return/
     * 
     * @param string $transaction_id Transaction Id
     * @param mixed $amount Order amount
     * @param string[optional] $order_number
     * @return array Transaction details
     */
    public function  returnPayment($transaction_id, $amount, $order_number = NULL) {

		//get endpoint
		$endpoint =  $this->_endpoint->getReturnsURL($transaction_id);

        $data['amount'] = $amount;
        if ( ! is_null($order_number)) {
            $data['order_number'] = $order_number;
        }
	
		return $this->_connector->processTransaction('POST', $endpoint, $data);

		
    }
    	
	
	    /**
     * Void (aka cancel)
     * @link http://developer.beanstream.com/documentation/take-payments/voids/
     * 
     * @param string $transaction_id Transaction Id
     * @param mixed $amount Order amount
     * @return array Transaction details
     */
    public function voidPayment($transaction_id, $amount) {
    
		//get endpoint
		$endpoint =  $this->_endpoint->getVoidsURL($transaction_id);
	
		$data['amount'] = $amount;
	
		//print_r($endpoint);die();
		return $this->_connector->processTransaction('POST', $endpoint, $data);
    }
    
	
	
	    /**
     * Take payment - profile
     * @link http://developer.beanstream.com/documentation/tokenize-payments/take-payment-profiles/
     * 
     * @param string $pid Profile Id
     * @param int $cid Card Id
     * @param array $data Order data
     * @param bool[optional] $complete Set to false for pre-auth
     * @return array Transaction details
     */
    public function makeProfilePayment($profile_id, $card_id, $data, $complete = TRUE) {
    	
		$endpoint =  $this->_endpoint->getBasePaymentsURL();
		
		//force profile
		$data['payment_method'] = 'payment_profile';
		
		$data['payment_profile'] = array(
                'complete' => (is_bool($complete) === TRUE ? $complete : TRUE),
                'customer_code' => $profile_id,
                'card_id' => ''.$card_id,
            );
			
		return $this->_connector->processTransaction('POST', $endpoint, $data);
    }
    
	
	
	
	
	
	
	public function getTokenTest($data = NULL) {
		
		$endpoint =  $this->_endpoint->getTokenURL();
		
		//force token
		$data['payment_method'] = 'token';

		//get token
		$result =  $this->_connector->processTransaction('POST', $endpoint, $data);

		//check if we're good
		if ( !isset($result['token']) ) { //no token received
            throw new Exception('No Token Received', 0);
		}
		
		//return token
		return $result['token'];
		
		
	}
		
	
	
	
	public function makeLegatoTokenPayment($token, $data = NULL, $complete = TRUE) {
		
		$endpoint =  $this->_endpoint->getBasePaymentsURL();

		//force token
		$data['payment_method'] = 'token';
		//add token
		$data['token']['code'] = $token;
		$data['token']['name'] = (isset($data['name']) ? $data['name'] : '');
		$data['token']['complete'] = (is_bool($complete) === TRUE ? $complete : TRUE);
		
		//$data['merchant_id'] = $this->_config->getMerchantId();
		


		//print_r($data);die();

		return $this->_connector->processTransaction('POST', $endpoint, $data);
		
		
		
		
	}
	
	
	
	
		
		
}
