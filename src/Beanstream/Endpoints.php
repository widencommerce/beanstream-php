<?php

namespace Beanstream;

class Endpoints {
	
	
//TODO build thid out first


const PAYMENTS_URL = 'https://{0}.beanstream.com/api/{1}/payments';

const PREAUTH_COMPLETION_URL = 
const RETURNS_URL = 
const VOIDS_URL = 

const BASE_PROFILES_URL = 'https://{0}.beanstream.com/api';
const PROFILE_URL = 'https://{0}.beanstream.com/api/{1}/payments/{id}';

const CARDS_URL = 
const REPORTS_URL = 




public static final String BaseUrl = "https://{0}.beanstream.com/api";
public static final String BasePaymentsUrl = BaseUrl + "/{1}/payments";
public static final String GetPaymentUrl = BasePaymentsUrl + "/{2}";
public static final String BaseProfilesUrl = BaseUrl + "/{1}/profiles";
public static final String PreAuthCompletionsUrl = BasePaymentsUrl
+ "/{2}/completions";
public static final String ReturnsUrl = BasePaymentsUrl + "/{2}/returns";
public static final String VoidsUrl = BasePaymentsUrl + "/{2}/void";
public static final String ContinuationsUrl = BasePaymentsUrl
+ "/{2}/continue";
public static final String ProfileUri = BaseProfilesUrl + "/{id}";
public static final String CardsUri = ProfileUri + "/cards";
public static final String ReportsUrl = BaseUrl + "/{1}/reports";



	const BASE_URL = 'https://{0}beanstream.com/api'
	const PROTOCOL = 'https://';
	const API_LOCATION = 'beanstream.com/api';
	
	
	
	
	
}
