<?php 	namespace Beanstream;

/**
 * Enpoints class to build, format and return api endpoint urls based on incoming platform and version
 *  
 * @author Kevin Saliba
 */
class Endpoints {
	
	//set base api endpoint with {0} platform variable
	CONST BASE_URL = 'https://{0}.beanstream.com/api';

	//init endpoint holders
	protected $basePaymentsURL;
	protected $getPaymentURL;
	protected $baseProfilesURL;
	protected $preAuthCompletionsURL;
	protected $returnsURL;
	protected $voidsURL;
	protected $profileURI;
	protected $cardsURI;
	protected $reportsURL;
	protected $continuationsURL;
	protected $tokenizationURL;

	protected $_platform;
	protected $_version;
	
	
	function __construct($platform, $version) {
		
		
		//assign endpoints
		//payments
		$this->basePaymentsURL = self::BASE_URL . '/{1}/payments';
		$this->preAuthCompletionsURL = $this->basePaymentsURL . '/{2}/completions';
		$this->returnsURL = $this->basePaymentsURL . '/{2}/returns';
		$this->voidsURL = $this->basePaymentsURL . '/{2}/void';
		$this->continuationsURL = $this->basePaymentsURL . '/{2}/continue';
		$this->tokenizationURL = 'https://{0}.beanstream.com/scripts/tokenization/tokens';

		//profiles
		$this->baseProfilesURL = self::BASE_URL . '/{1}/profiles';
		$this->profileURI = $this->baseProfilesURL . '/{2}';
		$this->cardsURI = $this->profileURI . '/cards';
		$this->cardURI = $this->cardsURI . '/{3}';

		//reporting
		$this->reportsURL = self::BASE_URL . '/{1}/reports';
		$this->getPaymentURL = $this->basePaymentsURL . '/{2}';
		
		
		$this->_platform = $platform;
		$this->_version = $version;
		
	}


	//methods to build out and return endpoints
	
	
	//payments
	
	public function getBasePaymentsURL() {
		
		return msgfmt_format_message('en_US', $this->basePaymentsURL, array($this->_platform, $this->_version));
		
	}
	
	
	public function getPreAuthCompletionsURL($tid) {
		
		return msgfmt_format_message('en_US', $this->preAuthCompletionsURL, array($this->_platform, $this->_version, $tid));
		
	}
	
	public function getReturnsURL($tid) {
		
		return msgfmt_format_message('en_US', $this->returnsURL, array($this->_platform, $this->_version, $tid));
		
	}
	
	
	public function getVoidsURL($tid) {
		
		return msgfmt_format_message('en_US', $this->voidsURL, array($this->_platform, $this->_version, $tid));
		
	}
	
	
	
	public function getTokenURL() {
		
		return msgfmt_format_message('en_US', $this->tokenizationURL, array($this->_platform));
		
	}
	
	
	
	
	
	//profiles
	public function getProfilesURL() {
		
		return msgfmt_format_message('en_US', $this->baseProfilesURL, array($this->_platform, $this->_version));
		
	}
	
	
	
	
	
	//profiles get a single profile by pid
	public function getProfileURI($pid) {
		
		return msgfmt_format_message('en_US', $this->profileURI, array($this->_platform, $this->_version, $pid));
		
	}
	
	
	
	//profiles get the cards uri for this pid
	public function getCardsURI($pid) {
		
		return msgfmt_format_message('en_US', $this->cardsURI, array($this->_platform, $this->_version, $pid));
		
	}
	
	
	
	//profiles get a single card based on a card id for this pid
	public function getCardURI($pid, $cid) {
		
		return msgfmt_format_message('en_US', $this->cardURI, array($this->_platform, $this->_version, $pid, $cid));
		
	}
	
	
	
	//reporting
	public function getReportingURL() {
		
		return msgfmt_format_message('en_US', $this->reportsURL, array($this->_platform, $this->_version));
	}
	
	
	public function getPaymentUrl($tid) {
		
		return msgfmt_format_message('en_US', $this->getPaymentURL, array($this->_platform, $this->_version, $tid));
		
	}
	
	
	
	
}