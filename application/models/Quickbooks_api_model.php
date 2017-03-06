<?php

class Quickbooks_api_model extends CI_Model {

	function generate_oauth($redirect_url = null)
	{
		define('OAUTH_REQUEST_URL', 'https://oauth.intuit.com/oauth/v1/get_request_token');
		define('OAUTH_ACCESS_URL', 'https://oauth.intuit.com/oauth/v1/get_access_token');
		define('OAUTH_AUTHORISE_URL', 'https://appcenter.intuit.com/Connect/Begin');

		// The url to this page. it needs to be dynamic to handle runnable's dynamic urls
		define('CALLBACK_URL', site_url().'/'.$redirect_url);

		// cleans out the token variable if comming from
		// connect to QuickBooks button
		if(isset($_GET['start']))
		{
			unset($_SESSION['token']);
		}
		 
		try {

			$oauth = new OAuth(OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET, OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_URI);
			$oauth->enableDebug();
			$oauth->disableSSLChecks(); //To avoid the error: (Peer certificate cannot be authenticated with given CA certificates)

			if(!isset($_GET['oauth_token']) && !isset($_SESSION['token']))
			{
				// step 1: get request token from Intuit
			    $request_token = $oauth->getRequestToken(OAUTH_REQUEST_URL, CALLBACK_URL);
				$_SESSION['secret'] = $request_token['oauth_token_secret'];

				// step 2: send user to intuit to authorize 
				header('Location: '. OAUTH_AUTHORISE_URL .'?oauth_token='.$request_token['oauth_token']);
				exit;
			}
			
			if(isset($_GET['oauth_token']) && isset($_GET['oauth_verifier']))
			{
				// step 3: request a access token from Intuit
		    	$oauth->setToken($_GET['oauth_token'], $_SESSION['secret']);
				$access_token = $oauth->getAccessToken(OAUTH_ACCESS_URL);
				
				$_SESSION['token'] = serialize( $access_token );
			    $_SESSION['realmId'] = $_REQUEST['realmId'];  // realmId is legacy for customerId
			    $_SESSION['dataSource'] = $_REQUEST['dataSource'];
				
				$token = $_SESSION['token'] ;
				$realmId = $_SESSION['realmId'];
				$dataSource = $_SESSION['dataSource'];
				$secret = $_SESSION['secret'] ;

			    redirect($redirect_url);
			    exit;
		  	}
		 
		} catch(OAuthException $e) {
			echo "Got auth exception";
			echo '<pre>';
			print_r($e);
		}
	}

	function get_balancesheet($redirect_url = null)
	{
		if(!isset($_SESSION['token']))
		{
			$this->generate_oauth($redirect_url);
		}

		require_once(APPPATH.'libraries/Quickbooks/config.php');

		require_once(PATH_SDK_ROOT . 'Core/ServiceContext.php');
		require_once(PATH_SDK_ROOT . 'ReportService/ReportService.php');
		require_once(PATH_SDK_ROOT . 'ReportService/ReportName.php');
		require_once(PATH_SDK_ROOT . 'PlatformService/PlatformService.php');
		require_once(PATH_SDK_ROOT . 'Utility/Configuration/ConfigurationManager.php');

		//Specify QBO or QBD
		$serviceType = IntuitServicesType::QBO;

		// Get App Config
		$realmId = ConfigurationManager::AppSettings('RealmID');
		if (!$realmId)
		    exit("Please add realm to App.Config before running this sample.\n");


		// Prep Service Context
		$requestValidator = new OAuthRequestValidator(ConfigurationManager::AppSettings('AccessToken'),
		    ConfigurationManager::AppSettings('AccessTokenSecret'),
		    ConfigurationManager::AppSettings('ConsumerKey'),
		    ConfigurationManager::AppSettings('ConsumerSecret'));
		$serviceContext = new ServiceContext($realmId, $serviceType, $requestValidator);

		if (!$serviceContext)
		    exit("Problem while initializing ServiceContext.\n");

		// Prep Data Services
		$reportService = new ReportService($serviceContext);
		if (!$reportService)
		    exit("Problem while initializing ReportService.\n");

		$balanceSheet = $reportService->executeReport(ReportName::BALANCESHEET);

		if (!$balanceSheet){
		    return FALSE;
		    exit;
		}
		else{
		    return json_decode(json_encode($balanceSheet), true);
		    exit;
		}
	}

}