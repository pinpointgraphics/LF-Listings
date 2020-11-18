<?php

/**
* this function adds key value pair to database.
* like username = lflister
*/
function LF_add_settings($meta_key,$meta_value)
{
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();

	$table_name = $wpdb->prefix.'LF_listing_settings';

	$result = $wpdb->get_row( "SELECT * FROM $table_name WHERE meta_key = '".$meta_key."'" );

	if($result !== null)
	{
		$wpdb->update( $table_name, ['meta_value'=>$meta_value],['meta_key'=>$meta_key], $format = null, $where_format = null );
	}
	else
	{
		$result = $wpdb->replace( $table_name, ['meta_key'=>$meta_key,'meta_value'=>$meta_value],['%s','%s']);
	}

	if($result)
	{
		return true;
	}
	else
	{
		return false;
	}
}

/**
* this function updates the existing key value pair in db.
*/
function LF_update_settings($meta_key,$meta_value)
{
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix.'LF_listing_settings';
	$wpdb->update( $table_name, ['meta_value'=>$meta_value],['meta_key'=>$meta_key], $format = null, $where_format = null );
}

/**
* this function gets the value of the perticular key
*/
function LF_get_settings($meta_key)
{
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix.'LF_listing_settings';

	$result = $wpdb->get_row( "SELECT * FROM $table_name WHERE meta_key = '".$meta_key."'" );

	if($result){
		return $result->meta_value;
	}
	else{
		return false;
	}

}

/**
* this function gets the token from the listing provider.
* so that we can get the listings information.
*/
function getToken()
{
	$url = API_URL.'/tokens';
	$username = LF_get_settings('user_name');
	$password = LF_get_settings('password');
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-DOMAIN-NAME: ' . get_site_url()));
	$token = curl_exec($ch);
	curl_close($ch);

	if($token == "Invalid credentials.")
	{
		//die($token.' Please check credentials in the LF-Listings Setting menu.');
		?>
		<script>
			alert('Invalid credentials: Please check credentials in the LF-Listings Setting menu.');
		</script>
		<?php

	}

	return $token;
}

/**
* this function get the list of cities for given agent id.
*/
function getCities()
{
	$url = API_URL.'/accounts/'.LF_get_settings('agent_id').'?fields=cities';
	$username = LF_get_settings('user_name');
	$password = LF_get_settings('password');
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	$cities = curl_exec($ch);
	curl_close($ch);
	return json_decode($cities);

}

/**
* this function get the listings as per the search parameters.
*/
function getLFListings($page='',$mainSearch='', $municipalities='',$sale='',$bedroom='',$bathroom='',$property_Type='',
$priceFrom='',$priceTo='',$waterFront='',$sort='',$offices='',$agents='',$openhouse='',$slug='',$search='',
$style='',$ids='',$pagination='',$priceorder='',$per_row='',$index='',$list_per_page)
{
	if (empty($slug))
	{
		return ;
	}

	if (empty($_SESSION[$slug]))
	{
		$_SESSION[$slug] = [];
	}

	if ($page == '-1')
	{
		unset($_SESSION[$slug]);
		//session_unset();
		echo '<script>location.reload();</script>';
		return;
	}

    $searchBtnPress = false;
	if ($page == '-2')
	{
		$searchBtnPress = true;
		$_SESSION[$slug]['page'] = 1;
	}
	else
	{
		if (!empty($page))$_SESSION[$slug]['page'] = $page;
		if (!empty($priceorder))$_SESSION[$slug]['priceorder'] = $priceorder;
		if(!empty($waterFront))$_SESSION[$slug]['waterfront'] = $waterFront;
	}

	if ($searchBtnPress == true)
	{
		$_SESSION[$slug]['mainSearch'] = $mainSearch;
		$_SESSION[$slug]['location'] = $municipalities;
		$_SESSION[$slug]['sale'] = $sale;
		$_SESSION[$slug]['bedroom'] = $bedroom;
		$_SESSION[$slug]['bathroom'] = $bathroom;
		$_SESSION[$slug]['type'] = $property_Type;
		$_SESSION[$slug]['priceTo'] = $priceTo;
		$_SESSION[$slug]['priceFrom'] = $priceFrom;
		$_SESSION[$slug]['office'] = $offices;
		$_SESSION[$slug]['agent'] = $agents;
		$_SESSION[$slug]['openhouse'] = $openhouse;
		$_SESSION[$slug]['search'] = $search;
		$_SESSION[$slug]['style'] = $style;
		$_SESSION[$slug]['ids'] = $ids;
		$_SESSION[$slug]['pagination'] = $pagination;
		$_SESSION[$slug]['columns'] = $per_row;
		$_SESSION[$slug]['list-per-page'] = $list_per_page;
	}

	$slugVariable = $slug;
	include(LF_PLUGIN_DIR.'/LF-Listings-main.php');
}

/**
* this function gives detail of perticular db.
*/
function getLFListingsDetails($listkey){
	$token = getToken();

	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => API_URL."/properties?token=".$token."&listkey=".$listkey,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		$result = $err;
	} else {

		$result = json_decode($response);
	}
	return $result;
}

/**
* this function returns the image url with perticular height and width.
*/
function getLFImageProxy($url){
	$curl = curl_init();
	$imageWidth = LF_get_settings('LF_imageWidth');
	$imageHeight = LF_get_settings('LF_imageHeight');
	if(!empty($imageWidth) and !empty($imageHeight)){
		return $url."&w=".$imageWidth."&h=".$imageHeight;
	}
	else{
		return $url;
	}
}

function LFUpdateCSS()
{
	$pluginData = get_plugin_data(LF_PLUGIN_DIR.'/LF-Listings.php');
	$currentVersion = $pluginData['Version'];
	$lastVersion= LF_get_settings('last_css_updated_version');
	if(empty($lastVersion))
	{
		$lastVersion = '1.0.5'; // since when we started the css upgrade.
		LF_add_settings('last_css_updated_version',$lastVersion);
		if(empty(LF_get_settings('customCss')))
		{
			$contentTobePut  = file_get_contents(LF_PLUGIN_DIR.'/versioned_css/1.0.5.css');
			if (!empty($contentTobePut))
			{
				LF_add_settings('customCss',$contentTobePut);
			}
		}
	}
	file_put_contents(LF_PLUGIN_DIR.'/assets/css/lf-style.css',stripslashes_deep(LF_get_settings('customCss')));
	#we have moved to new filename for security purpose, since we have new file now, delete old
	if (file_exists(LF_PLUGIN_DIR.'/assets/css/style.css'))
	{
		unlink(LF_PLUGIN_DIR.'/assets/css/style.css');
	}
	$digits = explode (".", $lastVersion);
	$cssDir = LF_PLUGIN_DIR.'/versioned_css/';
	$digits[2]++;
	for ($digits[0]; $digits[0] <=1; $digits[0]++) {
		for ($digits[1]; $digits[1] <=1; $digits[1]++) {
			for ($digits[2]; $digits[2] <=25; $digits[2]++) {
				$version = implode('.', $digits);
				$cssFile = $cssDir.$version.".css";
				if(file_exists ($cssFile))
				{
					file_put_contents(LF_PLUGIN_DIR.'/assets/css/lf-style.css', "\n\n/*----- ".$version." append -----*/\n\n", FILE_APPEND | LOCK_EX);
					file_put_contents(LF_PLUGIN_DIR.'/assets/css/lf-style.css', file_get_contents($cssFile), FILE_APPEND | LOCK_EX);
				}
				if($currentVersion == $version)
				{
					break 3;
				}
			}
			$digits[2] = 0;
		}
		$digits[1] = 0;
	}
	$contentTobePut = file_get_contents(LF_PLUGIN_DIR.'/assets/css/lf-style.css');
	if (!empty($contentTobePut))
	{
		LF_add_settings('customCss',$contentTobePut);
	}
	LF_add_settings('last_css_updated_version', $currentVersion);

}

function isWebhookEnabled($agent_id)
{
	$token = getToken();

	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => API_URL."/webhook/check/".$agent_id."?token=".$token,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	$result = false;
	if (empty($err))
	{
		$responseDecoded = json_decode($response, true);
		if ($responseDecoded['error'] == 0)
		{

				$result = $responseDecoded['enabled'] != 0 ? true : false;
		}
	}
	return $result;
}

/** actions and its handlers **/
function emailActionHandler($params, $data) {
	$fromemail = LF_get_settings('fromEmail');
	$toEmailsString = $params['to'];

	$toEmailsArray = explode(",", $toEmailsString);

	if (!empty($fromemail))
	{
		$name = "Listing Notifier";
		$headers[] = "From: $name <$fromemail>";
		$headers[] = "Content-type: text/html" ;
		$friendlyUrl = strtolower(preg_replace("/[^a-zA-Z0-9 ]/"," ",$data['UnparsedAddress']));
		$friendlyUrl = preg_replace("/(\s+)/","-",ucwords(trim($friendlyUrl)));
		$message = '
			<div>We just added the following listing to your database :</div>
			<br>
			<table border="0">
				<tr>
					<td>Listing Id : </td>
					<td>'.$data['ListingId'].'</td>
				</tr>
				<tr>
					<td>Listing Key : </td>
					<td>'.$data['ListingKey'].'</td>
				</tr>
				<tr>
					<td>Address : </td>
					<td>'.$data['UnparsedAddress'].'</td>
				</tr>
				<tr>
					<td>City : </td>
					<td>'.$data['City'].'</td>
				</tr>
				<tr>
					<td>Postal Code : </td>
					<td>'.$data['PostalCode'].'</td>
				</tr>
				<tr>
					<td>Link : </td>
					<td>'.home_url(LF_get_settings('LF_homepageSlug')).'/'.$data['ListingKey'].'/'.strtolower($friendlyUrl).'</td>
				</tr>
			</table>
			<br>
			<div>Powered by Lightning Fast Listings WordPress Plugin https://lightningfastlistings.ca</div>
		';

		$urlparts = parse_url(home_url());
		$domain = $urlparts['host'];
		foreach ($toEmailsArray as $to) {
			wp_mail( $to, '[ '.$domain.' ] : Your new listing has been added', $message, $headers );
		}
	}
}

function externalLinkCallActionHandler($params, $data)
{
	if (empty($params['url']) || empty($data))
		 {
						 return;
		 }

		 $data = $data->get_params();
		 $ch = curl_init();

			 curl_setopt($ch, CURLOPT_URL, $params['url']);
			 curl_setopt($ch, CURLOPT_POST, 1);
			 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			 curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
			 curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
			 curl_exec ($ch);
}

function newListingWebhookCallback($request)
{
	// JSON for actions
	// {
	//   "emailAction" : {
	//     "emailActionHandler" : {
	//       "to" : "xyz@gmail.com",
	//       "enabled" : true
	//     }
	//   },
	//   "externalLinkCallAction" : {
	//     "externalLinkCallActionHandler" : {
	//       "url" : "http://abcd.com",
	//       "enabled" : false
	//     }
	//   }
	// }

	$webhookJSON = LF_get_settings('webhookActions');
	$jsonDecoded = json_decode($webhookJSON, true);
	foreach ($jsonDecoded as $actionName => $actionDetails) {
			foreach ($actionDetails as $functionName => $functionParamsArray) {
					if ($functionParamsArray['enabled'] == true)
					{
								$functionName($functionParamsArray, $request);
					}
			}
	}
	return 'ok';
}

?>
