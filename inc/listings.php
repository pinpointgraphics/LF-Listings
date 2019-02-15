<?php
add_action( 'wp_ajax_LF_pagination', 'LF_pagination' );
add_action( 'wp_ajax_nopriv_LF_pagination', 'LF_pagination' );

function LF_pagination(){
	check_ajax_referer( 'my-special-string', 'token' );

	$page = sanitize_text_field($_POST['page']);
	$mainSearch = sanitize_text_field($_POST['mainSearch']);
	$municipality = sanitize_text_field($_POST['LF_municipalities']);
	$sale = sanitize_text_field($_POST['sale']);
	$bedroom = sanitize_text_field($_POST['bedroom']);
	$bathroom = sanitize_text_field($_POST['bathroom']);
	$property_Type = sanitize_text_field($_POST['property_Type']);
	$priceFrom = sanitize_text_field($_POST['priceFrom']);
	$priceTo = sanitize_text_field($_POST['priceTo']);
	$waterFront = sanitize_text_field($_POST['waterFront']);
	$sort = sanitize_text_field($_POST['sort']);
	$agents = sanitize_text_field($_POST['agents']);
	$offices = sanitize_text_field($_POST['offices']);
	$openhouse = sanitize_text_field($_POST['openhouse']);
	$slug = sanitize_text_field($_POST['slug']);
	$search = sanitize_text_field($_POST['search']);
	$style = sanitize_text_field($_POST['style']);
	$ids = sanitize_text_field($_POST['ids']);

	if(isset($style)){
		$style = $style;
	}
	else{
		$style = '';
	}

	if(isset($search)){
		$search = $search;
	}
	else{
		$search = '';
	}

	if(isset($ids)){
		$ids = $ids;
	}
	else{
		$ids='';
	}

	if(isset($openhouse)){
		$openhouse = $openhouse;
	}
	else{
		$openhouse = '';
	}

	if(isset($agents)){
		$agents = $agents;
	}
	else{
		$agents = '';
	}
	if(isset($offices)){
		$offices = $offices;
	}
	else{
		$offices = '';
	}
	if(isset($mainSearch))
	{
		$mainSearch = $mainSearch;
	}
	else{
		$mainSearch = '';
	}

	if(isset($municipality)){
		$municipality = $municipality;
	}
	else{
		$municipality = '';
	}
	if(isset($sale)){
		$sale=$sale;
	}
	else{
		$sale='';
	}

	if(isset($bedroom)){
		$bedroom = $bedroom;
	}
	else{
		$bedroom='';
	}

	if(isset($bathroom)){
		$bathroom= $bathroom;
	}
	else{
		$bathroom='';
	}

	if(isset($property_Type)){
		$property_Type=$property_Type;
	}
	else{
		$property_Type='';
	}

	if(isset($priceFrom)){
		$priceFrom = $priceFrom;
	}
	else{
		$priceFrom='';
	}

	if(isset($priceTo)){
		$priceTo=$priceTo;
	}
	else{
		$priceTo='';
	}

	if(isset($waterFront)){
		$waterFront = $waterFront;
	}
	else{
		$waterFront='';
	}
	getLFListings($page,$mainSearch,$municipality,$sale,$bedroom,$bathroom,$property_Type,$priceFrom,$priceTo,$waterFront,$sort,$offices,$agents,$openhouse,$slug,$search,$style,$ids);

	wp_die();
}

add_action( 'wp_ajax_LF_search', 'LF_search' );
add_action( 'wp_ajax_nopriv_LF_search', 'LF_search' );
function LF_search(){
	check_ajax_referer( 'my-special-string', 'token' );

	$mainSearch = sanitize_text_field($_POST['mainSearch']);
	$municipality = sanitize_text_field($_POST['LF_municipalities']);
	$sale = sanitize_text_field($_POST['sale']);
	$bedroom = sanitize_text_field($_POST['bedroom']);
	$bathroom = sanitize_text_field($_POST['bathroom']);
	$property_Type = sanitize_text_field($_POST['property_Type']);
	$priceFrom = sanitize_text_field($_POST['priceFrom']);
	$priceTo = sanitize_text_field($_POST['priceTo']);
	$waterFront = sanitize_text_field($_POST['waterFront']);
	$sort = sanitize_text_field($_POST['sort']);
	$agents = sanitize_text_field($_POST['agents']);
	$offices = sanitize_text_field($_POST['offices']);
	$openhouse = sanitize_text_field($_POST['openhouse']);
	$slug = sanitize_text_field($_POST['slug']);
	$search = sanitize_text_field($_POST['search']);
	$style = sanitize_text_field($_POST['style']);
	$ids = sanitize_text_field($_POST['ids']);

	if(isset($style)){
		$style = $style;
	}
	else{
		$style = '';
	}
	if(isset($search)){
		$search = $search;
	}
	else{
		$search = '';
	}
	if(isset($ids)){
		$ids = $ids;
	}
	else{
		$ids='';
	}
	if(isset($openhouse)){
		$openhouse = $openhouse;
	}
	else{
		$openhouse = '';
	}
	if(isset($agents)){
		$agents = $agents;
	}
	else{
		$agents = '';
	}
	if(isset($offices)){
		$offices = $offices;
	}
	else{
		$offices = '';
	}
	if(isset($mainSearch))
	{
		$mainSearch = $mainSearch;
	}
	else{
		$mainSearch = '';
	}

	if(isset($municipality)){
		$municipality = $municipality;
	}
	else{
		$municipality = '';
	}

	if(isset($sale)){
		$sale=$sale;
	}
	else{
		$sale='';
	}

	if(isset($bedroom)){
		$bedroom = $bedroom;
	}
	else{
		$bedroom='';
	}

	if(isset($bathroom)){
		$bathroom= $bathroom;
	}
	else{
		$bathroom='';
	}

	if(isset($property_Type)){
		$property_Type=$property_Type;
	}
	else{
		$property_Type='';
	}

	if(isset($priceFrom)){
		$priceFrom = $priceFrom;
	}
	else{
		$priceFrom='';
	}

	if(isset($priceTo)){
		$priceTo=$priceTo;
	}
	else{
		$priceTo='';
	}

	if(isset($waterFront)){
		$waterFront = $waterFront;
	}
	else{
		$waterFront='';
	}

	getLFListings($page,$mainSearch,$municipality,$sale,$bedroom,$bathroom,$property_Type,$priceFrom,$priceTo,$waterFront,$sort,$offices,$agents,$openhouse,$slug,$search,$style);
	wp_die();
}


add_action( 'wp_ajax_LF_send_inquiryMail', 'LF_send_inquiryMail' );
add_action( 'wp_ajax_nopriv_LF_send_inquiryMail', 'LF_send_inquiryMail' );
/**
* this function sends inquiry emails.
*/
function LF_send_inquiryMail()
{
	check_ajax_referer( 'my-special-string', 'token' );
	$property = sanitize_text_field($_POST['txtSubject']);
	$name = sanitize_text_field($_POST['txtName']);
	$fromemail = LF_get_settings('fromEmail');
	$toemail = LF_get_settings('email');
	$email = sanitize_text_field($_POST['txtemail']);
	$subject = "Inquiry for ".$property;
	$txtMessage = sanitize_text_field($_POST['txtMessage']);
	$message = '
	<p>Hey admin, you the the listings inquiry</p>
	<table border="0">
	<tr>
	<td>Property Id: </td>
	<td>'.$property.'</td>
	</tr>
	<tr>
	<td>Name: </td>
	<td>'.$name.'</td>
	</tr>
	<tr>
	<td>Email: </td>
	<td>'.$email.'</td>
	</tr>
	<tr>
	<td>Message: </td>
	<td>'.$txtMessage.'</td>
	</tr>
	</table>
	';
	$headers[] = "From: $name <$fromemail>";
	$headers[] = "Content-type: text/html" ;

	$sent = wp_mail( $toemail, $subject, $message, $headers );
	echo $sent;
	die();
}


function LF_SessionStart()
{
	check_ajax_referer( 'my-special-string', 'token' );
	$_SESSION['acceptTerms']=$_SERVER['REMOTE_ADDR'];
	die();
}
add_action( 'wp_ajax_LF_SessionStart', 'LF_SessionStart' );
add_action( 'wp_ajax_nopriv_LF_SessionStart', 'LF_SessionStart' );
?>
