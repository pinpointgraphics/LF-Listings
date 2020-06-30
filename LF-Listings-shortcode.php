<?php

$attr = shortcode_atts( array(
	'type' => 'any',
	'sale' => '',
	'location'=>'',
	'agent'=>'',
	'office'=>'',
	'openhouse'=>'',
	'search'=>'',
	'style'=>'',
	'ids'=>'',
	'pagination'=>'',
	'priceorder'=>'',
	'columns'=>'',
	'waterfront'=>'',
	'popup'=>'',
	'list-per-page'=>'',
	'selectable-locations'=>''
), $atts );

$listkey = get_query_var('listkey');
if ($listkey)
{
	$_SESSION['listkey']= $listkey;
	?>
	<style>
	h1.entry-title{
		display: none;
	}
	</style>

	<div  class="LF-listigs" id="listing-0">
			<img width="30" height="30" style="margin-left:15px;position: fixed;left: 40%;top: 50%;" src="<?php echo plugins_url('assets/images/loading.gif',__FILE__)?>" id="LF-loading-img">
	</div>
	<?php
	return;
}

if(isset($_SESSION['pageUpdated']) && $_SESSION['pageUpdated'] == "yes")
{ ?>
        <script>sessionStorage.clear();</script> <?php
        session_unset();
}


$slugVariable = getCurrentPageSlug().'-'.$tagCount;

if (empty($slugVariable))
	$slugVariable = LF_get_settings('LF_homepageSlug');

if (empty($_SESSION[$slugVariable]))
	$_SESSION[$slugVariable] = [];

if (empty($_SESSION[$slugVariable]['type']))$_SESSION[$slugVariable]['type'] = $attr['type']; 
if (!isset($_SESSION[$slugVariable]['sale']))$_SESSION[$slugVariable]['sale'] = $attr['sale'];
if (empty($_SESSION[$slugVariable]['location']))$_SESSION[$slugVariable]['location'] = $attr['location'];
if (empty($_SESSION[$slugVariable]['agent']))$_SESSION[$slugVariable]['agent'] = $attr['agent'];
if (empty($_SESSION[$slugVariable]['office']))$_SESSION[$slugVariable]['office'] = $attr['office'];
if (empty($_SESSION[$slugVariable]['openhouse']))$_SESSION[$slugVariable]['openhouse'] = $attr['openhouse'];
if (empty($_SESSION[$slugVariable]['search']))$_SESSION[$slugVariable]['search'] = $attr['search'];
if (empty($_SESSION[$slugVariable]['style']))$_SESSION[$slugVariable]['style'] = $attr['style'];
if (empty($_SESSION[$slugVariable]['ids']))$_SESSION[$slugVariable]['ids'] = $attr['ids'];
if (empty($_SESSION[$slugVariable]['pagination']))$_SESSION[$slugVariable]['pagination'] = $attr['pagination'];
if (empty($_SESSION[$slugVariable]['priceorder']) && !empty($attr['priceorder']))
{
	$_SESSION[$slugVariable]['priceorder'] = $attr['priceorder'];
}
if (empty($_SESSION[$slugVariable]['columns']))$_SESSION[$slugVariable]['columns'] = $attr['columns'];
if (empty($_SESSION[$slugVariable]['waterfront']))$_SESSION[$slugVariable]['waterfront'] = $attr['waterfront'];
if (empty($_SESSION[$slugVariable]['popup']))$_SESSION[$slugVariable]['popup'] = $attr['popup'];
if (empty($_SESSION[$slugVariable]['list-per-page']))$_SESSION[$slugVariable]['list-per-page'] = $attr['list-per-page'];
if (empty($_SESSION[$slugVariable]['selectable-locations']))$_SESSION[$slugVariable]['selectable-locations'] = $attr['selectable-locations'];

// extra
if (empty($_SESSION[$slugVariable]['allCities'])) $_SESSION[$slugVariable]['allCities'] = LF_get_settings('allCities');
if (empty($_SESSION[$slugVariable]['LF_Municipalities'])) $_SESSION[$slugVariable]['LF_Municipalities'] = LF_get_settings('LF_Municipalities');

?>

<div class="LF-listigs">
	<div class="LF-row" id="listing-<?php echo $tagCount;?>">
		<img width="30" height="30" style="margin-left:15px;position: fixed;left: 40%;top: 50%;" src="<?php echo plugins_url('assets/images/loading.gif',__FILE__)?>" id="LF-loading-img">
	</div>
	<div class="LF-row" id="listing-default-<?php echo $tagCount;?>">

		<input type="hidden" name="pageSlug" id="pageSlug" value="<?php echo $slugVariable;?>">

		<input type="hidden" name="defaultagents" id="defaultagents" value="<?php echo str_replace(' ', '', $_SESSION[$slugVariable]['agent']);?>">

		<input type="hidden" name="defaultoffice" id="defaultoffice" value="<?php echo str_replace(' ', '', $_SESSION[$slugVariable]['office']);?>">

		<input type="hidden" name="defaultlocation" id="defaultlocation" value="<?php echo !empty($_SESSION[$slugVariable]['location']) ? $_SESSION[$slugVariable]['location'] :'0'; ?>">

		<input type="hidden" name="defaultsale" id="defaultsale" value="<?php echo $_SESSION[$slugVariable]['sale'];?>">

		<input type="hidden" name="defaultopenhouse" id="defaultopenhouse" value="<?php echo $_SESSION[$slugVariable]['openhouse'];?>">

		<input type="hidden" name="defaultwaterfront" id="defaultwaterfront" value="<?php echo $_SESSION[$slugVariable]['waterfront'];?>">

		<input type="hidden" name="defaulttype" id="defaulttype" value="<?php echo !empty($_SESSION[$slugVariable]['type']) ?$_SESSION[$slugVariable]['type']:'';?>">

		<input type="hidden" name="search" id="search" value="<?php echo $_SESSION[$slugVariable]['search'];?>">

		<input type="hidden" name="style" id="style" value="<?php echo $_SESSION[$slugVariable]['style'];?>">

		<input type="hidden" name="noofcol" id="noofcol" value="<?php echo $_SESSION[$slugVariable]['columns'];?>">

		<input type="hidden" name="ids" id="ids" value="<?php echo !empty($_SESSION[$slugVariable]['ids']) ?str_replace(' ', '', $_SESSION[$slugVariable]['ids']):'';?>">

		<input type="hidden" name="pagination" id="pagination" value="<?php echo $_SESSION[$slugVariable]['pagination'];?>">

		<input type="hidden" name="priceorder" id="priceorder" value="<?php echo $attr['priceorder'];?>">

		<input type="hidden" name="per_row" id="per_row" value="<?php echo $_SESSION[$slugVariable]['columns'];?>">

		<input type="hidden" name="list_per_page" id="list_per_page" value="<?php echo $_SESSION[$slugVariable]['list-per-page'];?>">
</div>
</div>
