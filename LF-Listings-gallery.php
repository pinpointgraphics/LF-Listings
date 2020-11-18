<?php $output = explode("-",$slugVariable);
$tagCounter = $output[count($output)-1]; ?>
<div class="LF-listigs" id="listing-<?php echo $tagCounter;?>">
    <?php
    $hasValidLocation = true;
    if ($slugVariable != 'wp-admin-1' && (empty($_SESSION[$slugVariable]['search']) OR $_SESSION[$slugVariable]['search']=='yes' OR $_SESSION[$slugVariable]['search']=="only")):
        if(LF_get_settings('LF_show_search')=='yes'  || (($_SESSION[$slugVariable]['search']=='yes' OR $_SESSION[$slugVariable]['search']=='only') AND LF_get_settings('LF_show_search')!='yes')):
            $priceFrom = $_SESSION[$slugVariable]['priceFrom'];
            $priceTo = $_SESSION[$slugVariable]['priceTo'];
            $bathroom = $_SESSION[$slugVariable]['bathroom'];
            $bedroom = $_SESSION[$slugVariable]['bedroom'];

            $DBLF_Municipalities = '';
            if (!empty($_SESSION[$slugVariable]['allCities']))
            {
                $DBLF_Municipalities = $_SESSION[$slugVariable]['allCities'];
            }
            else
            {
                $DBLF_Municipalities = getCities();
                $DBLF_Municipalities = implode(',', get_object_vars($DBLF_Municipalities->results->cities));
		$_SESSION[$slugVariable]['allCities'] = $DBLF_Municipalities;
                LF_add_settings('allCities', $DBLF_Municipalities);
            }
            $DBLF_Municipalities = explode(',', $DBLF_Municipalities);

            $shouldValidate = false;
            $LF_Municipalities = array();
            if (!empty($_SESSION[$slugVariable]['selectable-locations']))
            {
                $LF_Municipalities = $_SESSION[$slugVariable]['selectable-locations'];
                $shouldValidate = true;
            }
            else if (!empty($_SESSION[$slugVariable]['LF_Municipalities']))
            {
                $LF_Municipalities = $_SESSION[$slugVariable]['LF_Municipalities'];
            }

            $LF_Municipalities = explode(',', $LF_Municipalities);

            if (!empty($_SESSION[$slugVariable]['location']) && !in_array($_SESSION[$slugVariable]['location'], $LF_Municipalities))
            {
		foreach (explode(',',$_SESSION[$slugVariable]['location']) as $location) {

			if (!in_array($location, $LF_Municipalities)) {
				$LF_Municipalities[] = $location;
			}
		}
                $shouldValidate = true;
            }

            if ($shouldValidate == true)
            {
                foreach($LF_Municipalities as $LF_Municipality)
                {
                    if (!in_array($LF_Municipality, $DBLF_Municipalities))
                    {
            			$hasValidLocation = false;
            			$invalidLocation = $LF_Municipality;
                    }
                }
            }

            ?>
            <div class="LF-row">
                <form method="post" name="search">
                    <div class="LF-col-md-12">
                        <div class="formmessage"></div>
                    </div>
                    <div class="LF-col-md-6">
                        <div class="LF-form-group">
                            <input type="text" name="LF_main_search" id="LF_main_search" class="LF-form-control" placeholder="Search by Location, City, Postal Code or ID#" value="<?php echo$_SESSION[$slugVariable]['mainSearch'];?>" maxlength="20">
                        </div>
                    </div>
                    <div class="LF-col-md-6">
                        <div class="LF-form-group">
                            <select name="LF_municipalities" id="LF_municipalities" class="LF-form-control">
                                <option value="0">All Municipalities</option>
                                <?php
                                foreach($LF_Municipalities as $LF_Municipalitie):
                                    if($_SESSION[$slugVariable]['location'] == $LF_Municipalitie)
                                    {
                                        $select = "selected";
                                    }
                                    else
                                    {
                                        $select='';
                                    }
                                    echo '<option value="'.$LF_Municipalitie.'"'.$select.'>'.$LF_Municipalitie.'</option>';
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="LF-col-md-4">
                        <div class="LF-form-group">
                            <select name="LF_sale" id="LF_sale" class="LF-form-control">
                                <option value="0">For Sale or Rent</option>
                                <option value="sale" <?php if($_SESSION[$slugVariable]['sale']=='sale'){ echo 'selected';}?>>Sale</option>
                                <option value="rent" <?php if($_SESSION[$slugVariable]['sale']=='rent'){ echo 'selected';}?>>Rent</option>
                            </select>
                        </div>
                    </div>
                    <div class="LF-col-md-4">
                        <div class="LF-form-group">
                            <select name="LF_bedroom" id="LF_bedroom" class="LF-form-control">
                                <option value="0">Any</option>
                                <option value="1" <?php if($bedroom=='1'){ echo 'selected';}?>>1</option>
                                <option value="2" <?php if($bedroom=='2'){ echo 'selected';}?>>2</option>
                                <option value="3" <?php if($bedroom=='3'){ echo 'selected';}?>>3</option>
                                <option value="4" <?php if($bedroom=='4'){ echo 'selected';}?>>4</option>
                                <option value="5" <?php if($bedroom=='5'){ echo 'selected';}?>>5+</option>
                            </select>
                        </div>
                    </div>
                    <div class="LF-col-md-4">
                        <div class="LF-form-group">
                            <select name="LF_bathroom" id="LF_bathroom" class="LF-form-control">
                                <option value="0">Any</option>
                                <option value="1" <?php if($bathroom=='1'){ echo 'selected';}?>>1</option>
                                <option value="2" <?php if($bathroom=='2'){ echo 'selected';}?>>2</option>
                                <option value="3" <?php if($bathroom=='3'){ echo 'selected';}?>>3</option>
                                <option value="4" <?php if($bathroom=='4'){ echo 'selected';}?>>4</option>
                                <option value="5" <?php if($bathroom=='5'){ echo 'selected';}?>>5+</option>
                            </select>
                        </div>
                    </div>
                    <div class="LF-col-md-4">
                        <div class="LF-form-group">
                            <select name="LF_property_search" id="LF_property_search" class="LF-form-control">
                                <option value="any" <?php if($_SESSION[$slugVariable]['type']=='any'){ echo 'selected';}?>>All Property Types</option>
                                <option value="residential" <?php if($_SESSION[$slugVariable]['type']=='residential'){ echo 'selected';}?>>Residential</option>
                                <option value="commercial" <?php if($_SESSION[$slugVariable]['type']=='commercial'){ echo 'selected';}?>>Commercial</option>
                                <option value="condo" <?php if($_SESSION[$slugVariable]['type']=='condo'){ echo 'selected';}?>>Condo/Strata</option>
                                <option value="recreational" <?php if($_SESSION[$slugVariable]['type']=='recreational'){ echo 'selected';}?>>Recreational</option>
                                <option value="agriculture" <?php if($_SESSION[$slugVariable]['type']=='agriculture'){ echo 'selected';}?>>Agriculture</option>
                                <option value="land" <?php if($_SESSION[$slugVariable]['type']=='land'){ echo 'selected';}?>>Vacant Land</option>
                            </select>
                        </div>
                    </div>
                    <div class="LF-col-md-4">
                        <div class="LF-form-group">
                            <select id="LF_pricefrom_search" name="LF_pricefrom_search" class="LF-form-control">
                                <option value="">Price From</option>

                                <option value="0" <?php if($priceFrom=='0'){ echo 'selected';}?>>0</option>
                                <?php

                                for($i=25000;$i <=500000;$i+=25000){
                                    ?>
                                    <option value="<?php echo $i;?>" <?php if($priceFrom==$i){ echo 'selected';}?>><?php echo number_format($i);?></option>
                                <?php } ?>
                                <?php
                                $value = 500000;
                                for($i=550000;$i <=1000000;$i+=50000){
                                    ?>
                                    <option value="<?php echo $i;?>" <?php if($priceFrom==$i){ echo 'selected';}?>><?php echo number_format($i);?></option>
                                <?php } ?>

                                <?php

                                for($i=1100000;$i <=2000000;$i+=100000){
                                    ?>
                                    <option value="<?php echo $i;?>" <?php if($priceFrom==$i){ echo 'selected';}?>><?php echo number_format($i);?></option>
                                <?php } ?>
                                <?php

                                for($i=2500000;$i <=7500000;$i+=500000){
                                    ?>
                                    <option value="<?php echo $i;?>" <?php if($priceFrom==$i){ echo 'selected';}?>><?php echo number_format($i);?></option>
                                <?php } ?>

                                <option value="10000000 " <?php if($priceFrom=='10000000'){ echo 'selected';}?>>10,000,000 </option>
                                <option value="15000000" <?php if($priceFrom=='15000000'){ echo 'selected';}?>>15,000,000</option>
                                <option value="20000000" <?php if($priceFrom=='20000000'){ echo 'selected';}?>>20,000,000</option>
                            </select>
                        </div>
                    </div>
                    <div class="LF-col-md-4">
                        <div class="LF-form-group">
                            <select id="LF_priceto_search" name="LF_priceto_search" class="LF-form-control">
                                <option value="">Price To</option>
                                <option value="0" <?php if($priceTo=='0'){ echo 'selected';}?>>0</option>
                                <?php

                                for($i=25000;$i <=500000;$i+=25000){
                                    ?>
                                    <option value="<?php echo $i;?>" <?php if($priceTo==$i){ echo 'selected';}?>><?php echo number_format($i);?></option>
                                <?php } ?>
                                <?php
                                $value = 500000;
                                for($i=550000;$i <=1000000;$i+=50000){
                                    ?>
                                    <option value="<?php echo $i;?>" <?php if($priceTo==$i){ echo 'selected';}?>><?php echo number_format($i);?></option>
                                <?php } ?>

                                <?php

                                for($i=1100000;$i <=2000000;$i+=100000){
                                    ?>
                                    <option value="<?php echo $i;?>" <?php if($priceTo==$i){ echo 'selected';}?>><?php echo number_format($i);?></option>
                                <?php } ?>
                                <?php

                                for($i=2500000;$i <=7500000;$i+=500000){
                                    ?>
                                    <option value="<?php echo $i;?>" <?php if($priceTo==$i){ echo 'selected';}?>><?php echo number_format($i);?></option>
                                <?php } ?>

                                <option value="10000000 " <?php if($priceTo=='10000000'){ echo 'selected';}?>>10,000,000 </option>
                                <option value="15000000" <?php if($priceTo=='15000000'){ echo 'selected';}?>>15,000,000</option>
                                <option value="20000000" <?php if($priceTo=='20000000'){ echo 'selected';}?>>20,000,000</option>
                            </select>
                        </div>
                    </div>
                    <div class="LF-col-md-12">
                        <div class="LF-form-group">
                            <label id="waterfront-search" for="waterfront">
                                <input id="waterfront" name="waterfront" <?php if(!empty($_SESSION[$slugVariable]['waterfront']) and $_SESSION[$slugVariable]['waterfront']=='yes'){ echo 'checked';}?> value="y" type="checkbox">Show waterfront properties only
                            </label>
                        </div>
                        <div class="LF-form-group">
                            <button class="LF-btn LF-btn-search" type="button">Search</button>
                            <button class="LF-btn LF-btn-reset" type="button" onclick="resetSearch(this)">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
            <?php
        endif; //end check search enable/disable from admin
    endif; //end search tag in shortcode

    if ($hasValidLocation == false)
    {
                        ?>
                        <script>
                        var popup = document.getElementById('Modal');
                        popup.style.display = 'none';
                        </script>
                        <?php
                        echo 'Hey Admin!  '.$invalidLocation.' is not a valid location in the feed. Its case sensitive. Please correct from the admin menu or tag.';
                        return;
   }

    $token = getToken();
    $agent_id = LF_get_settings('agent_id');
    $office_id = LF_get_settings('office_id');
    if(!empty($_SESSION[$slugVariable]['agent'])){
        $agents = str_replace(' ', '', $_SESSION[$slugVariable]['agent']);
        $agent = '&agents='.$agents;
    }
    else{
        $agent = '';
    }

    if(!empty($_SESSION[$slugVariable]['office'])){
        $offices = str_replace(' ', '', $_SESSION[$slugVariable]['office']);
        $office = '&offices='.$offices;
    }
    else{
        $office = '';
    }
    if(!empty($_SESSION[$slugVariable]['openhouse'])){
        $openhouse = '&openhouse='.$_SESSION[$slugVariable]['openhouse'];
    }
    else{
        $openhouse = '';
    }

    if(!empty($_SESSION[$slugVariable]['location'])){
        $search = '&area='.urlencode($_SESSION[$slugVariable]['location']);
    }
    else{
        $search = '';
    }

    if(!empty($_SESSION[$slugVariable]['ids'])){
        $lids = str_replace(' ', '', $_SESSION[$slugVariable]['ids']);
        $ids = '&ids='.$lids;
    }
    else{
        $ids = '';
    }
    if($_SESSION[$slugVariable]['style']=='horizontal'){
        $paginate = '50';
    }
    elseif(!empty($_SESSION[$slugVariable]['list-per-page'])){
        if($_SESSION[$slugVariable]['list-per-page']>48){
            $paginate = 48;
        }
        else{
            $paginate = $_SESSION[$slugVariable]['list-per-page'];
        }
    }
    else{
        $paginate = LF_get_settings('LF_page');
    }

    $sort = LF_get_settings('LF_priceOrder');
    if(!empty($_SESSION[$slugVariable]['priceorder']))
    {
        if($_SESSION[$slugVariable]['priceorder']=='up' || $_SESSION[$slugVariable]['priceorder']=='DESC')
        {
            $sort = 'DESC';
        }
        elseif($_SESSION[$slugVariable]['priceorder']=='down' || $_SESSION[$slugVariable]['priceorder']=='ASC')
        {
            $sort = 'ASC';
        }
    }

    elseif(!isset($sort)){
        $sort = 'ASC';
    }

    if(!empty($_SESSION[$slugVariable]['sale'])){
        $sale = '&sale='.$_SESSION[$slugVariable]['sale'];
    }
    else{
        $sale = '';
    }

    if(!empty($_SESSION[$slugVariable]['waterfront']) and $_SESSION[$slugVariable]['waterfront']=='yes'){
        $waterfront = '&waterfront=y';
    }
    else{
        $waterfront = '';
    }

    if(!empty($_SESSION[$slugVariable]['page']) && $_SESSION[$slugVariable]['page']!=''){
        $page = '&page='.$_SESSION[$slugVariable]['page'];
    }
    else{
        $page = '';
    }

    if(!empty($_SESSION[$slugVariable]['mainSearch']) && $_SESSION[$slugVariable]['mainSearch']!=''){
        $mainSearch='&search='.$_SESSION[$slugVariable]['mainSearch'];
    }
    else{
        $mainSearch = '';
    }

    if(!empty($_SESSION[$slugVariable]['bedroom']) && $_SESSION[$slugVariable]['bedroom']!=''){
        $bedroom = '&bed='.$_SESSION[$slugVariable]['bedroom'];
    }
    else{
        $bedroom = '';
    }

    if(!empty($_SESSION[$slugVariable]['bathroom']) && $_SESSION[$slugVariable]['bathroom']!=''){
        $bathroom = '&bath='.$_SESSION[$slugVariable]['bathroom'];
    }
    else{
        $bathroom='';
    }

    if(!empty($_SESSION[$slugVariable]['priceFrom']) && $_SESSION[$slugVariable]['priceFrom']!=''){
        $priceFrom = '&pricefrom='.$_SESSION[$slugVariable]['priceFrom'];
    }
    else{
        $priceFrom = '';
    }

    if(!empty($_SESSION[$slugVariable]['priceTo']) && $_SESSION[$slugVariable]['priceTo']!=''){
        $priceTo = '&priceto='.$_SESSION[$slugVariable]['priceTo'];
    }
    else{
        $priceTo = '';
    }


    $url = API_URL."/properties?token=".$token."&agent_id=".$agent_id."&office_id=".$office_id."&paginate=".$paginate."&type=".$_SESSION[$slugVariable]['type']."&sort=".$sort.$sale.$search.$agent.$office.$ids.$waterfront.$openhouse.$page.$mainSearch.$bedroom.$bathroom.$priceFrom.$priceTo;
    $url = str_replace(" ", '%20', $url);

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
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
        echo "cURL Error #:" . $err;
    } else {

        $page_id = get_the_ID();
        $pageSlug = substr($slugVariable, 0, strrpos( $slugVariable, '-'));

        if(is_admin() || is_home() || is_front_page()){
            if(!empty(LF_get_settings('LF_homepageSlug')))					{
                $pageSlug = LF_get_settings('LF_homepageSlug');
            }
            else{
                $option_name = 'LF-Listings';
                $postContent = LF_find_shortcode_occurencesName($option_name);
            }
        }

        $result = json_decode($response);
        if(empty($result)){
            return true;
        }
        if(empty($_SESSION[$slugVariable]['columns'])){
            $column = LF_get_settings('LF_column');
        }
        else{
            $column = $_SESSION[$slugVariable]['columns'];
        }
        ?>
        <div class="LF-row">
            <?php

            if(empty($_SESSION[$slugVariable]['search']) or $_SESSION[$slugVariable]['search']!="only" or $_SESSION[$slugVariable]['search']=="no" or $_SESSION[$slugVariable]['search'] == 'yes'){
                if($result->error==false){

                    $current_page = $result->results->current_page;
                    $last = ceil($result->results->total / $result->results->per_page);
                    $links = 5;
                    $a = ceil($links/2);
                    $start      = ( ( $current_page - $links + $a) > 0 ) ? $current_page - $links + $a : 1;
                    $end        = ( ( $current_page + $links - $a) < $last ) ? $current_page + $links - $a: $last;
                    $class      = ( $current_page == 1 ) ? "disabled" : "";

                    $html       = '<ul class="LF-pagination">';

                    if($current_page>1){
                        $prev=$current_page-1;
                        $html   .= '<li><a href="javascript:void(0);" data-page="'.$prev.'">Prev</a></li>';
                    }

                    if ( $start > 1 ) {
                        $html   .= '<li><a href="javascript:void(0);" data-page="1">1</a></li>';
                        $html   .= '<li class="disabled"><span>...</span></li>';
                    }
                    if($end>1){
                        for ( $i = $start ; $i <= $end; $i++ ) {
                            $class  = ( $current_page == $i ) ? "active" : "";
                            $html   .= '<li class="' . $class . '"><a href="javascript:void(0);" data-page="'.$i.'">' . $i . '</a></li>';
                        }
                    }
                    if ( $end < $last ) {
                        $html   .= '<li class="disabled"><span>...</span></li>';
                        $html   .= '<li><a href="javascript:void(0);" data-page="'.$last.'">' . $last . '</a></li>';
                    }

                    if($current_page < $last){
                        $next = $current_page + 1;
                        $html   .= '<li><a href="javascript:void(0);" data-page="'.$next.'">Next</a></li>';
                    }
                    $html       .= '</ul><div class="LF-clear"></div>';

                    $ascchecked = 'checked';
                    $ascchecked = $sort == 'ASC' ? 'checked' : '';
                    $descchecked = $sort=='DESC' ? 'checked' : '';

                    echo '<div class="LF-col-md-7">';
                    if((empty($_SESSION[$slugVariable]['pagination']) || $_SESSION[$slugVariable]['pagination'] == 'yes') and $_SESSION[$slugVariable]['style'] != 'horizontal'){
                        echo $html;
                    }
                    echo '</div>';

                    if((empty($_SESSION[$slugVariable]['priceorder']) && LF_get_settings('LF_show_priceOrder')=='yes') || ( !empty($_SESSION[$slugVariable]['priceorder']) && $_SESSION[$slugVariable]['priceorder']!='no')){
                        echo '<div class="LF-col-md-5">
                        <div class="LF-sortblock">
                        <label>Order by price: </lable>
                        Low <input type="radio" class="LF-sort" name="LF-sort" id="asc" value="ASC" '.$ascchecked.'>
                        High <input type="radio" class="LF-sort" name="LF-sort" id="desc" value="DESC" '.$descchecked.'>
                        </div>
                        </div>&nbsp;';
                    }
                    echo '<div class="clear"></div>';

                    switch($column){
                        case 0:
                        $col=0;
                        break;
                        case 1:
                        $col=12;
                        break;
                        case 2:
                        $col=6;
                        break;
                        case 3:
                        $col=4;
                        break;
                        case 4:
                        $col=3;
                        break;
                        default:
                        $col=3;
                        break;
                    }

                    if(!empty($_SESSION[$slugVariable]['style']) and $_SESSION[$slugVariable]['style'] == 'horizontal'){
                        echo '<div class="horizantal-slide">';
                    }
                    foreach($result->results->data as $propertyList){
                        if($col==0){
                            ?>
                            <div class="LF-col-md-12">
                                <div class="LF-listing-details LF-listview">
                                    <div class="LF-row">
                                        <div class="LF-col-md-4">
                                            <div
                                            <?php
                                            if ($slugVariable == 'wp-admin-1')
                                            {
                                                echo ' class="LF-image-admin"';
                                            }
                                            else
                                            {
                                                echo ' class="LF-image"';
                                            }
                                            ?>>
                                                <a href="<?php echo home_url($pageSlug).'/'.$propertyList->ListingKey.'/'.strtolower($propertyList->FriendlyUrl);?>">
                                                    <img src="<?php echo getLFImageProxy($propertyList->ListingThumb);?>" alt="">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="LF-col-md-8">
                                            <div class="LF-header">
                                                <span class="LF-heading-link"><?php echo '#'.$propertyList->OriginatingSystemKey?></span>
                                            </div>
                                            <div class="LF-details">
                                                <div class="LF-price"><?php echo '$'.$propertyList->ListPriceFormatted;?></div>
                                                <div class="LF-address">
                                                    <?php echo $propertyList->FullAddress;
							if (!empty($propertyList->BuildingAreaTotal) && !empty($propertyList->BuildingAreaUnits)) {?>
                                                    <p><?php echo $propertyList->BuildingAreaTotal.' '.$propertyList->BuildingAreaUnits?></p>
								<?php } ?>
                                                </div>
                                                <a href="<?php echo home_url($pageSlug).'/'.$propertyList->ListingKey.'/'.strtolower($propertyList->FriendlyUrl);?>" class="LF-btn LF-btn-link">View Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        else{
                            ?>
                            <div class="LF-col-md-<?= $col?> LF-col-sm-6 LF-col-xs-12">
                                <div class="LF-listing-details LF-gridview">
                                    <div class="LF-header">
                                        <span class="LF-heading-link"><?php echo '#'.$propertyList->OriginatingSystemKey?></span>
                                    </div>
                                    <div
                                    <?php
                                    if ($slugVariable == 'wp-admin-1')
                                    {
                                        echo ' class="LF-image-admin"';
                                    }
                                    else
                                    {
                                        echo ' class="LF-image"';
                                    }
                                    ?>>
                                        <a href="<?php echo home_url($pageSlug).'/'.$propertyList->ListingKey.'/'.strtolower(str_replace(' ','-',$propertyList->City)).'/'.strtolower($propertyList->FriendlyUrl);?>">
                                            <img src="<?php echo getLFImageProxy($propertyList->ListingThumb);?>" alt="">
                                        </a>
                                    </div>
                                    <div class="LF-details">
                                        <a href="<?php echo home_url($pageSlug).'/'.$propertyList->ListingKey.'/'.strtolower(str_replace(' ','-',$propertyList->City)).'/'.strtolower($propertyList->FriendlyUrl);?>" class="LF-btn LF-btn-link">View Details</a>
                                        <div class="LF-price"><?php echo '$'.$propertyList->ListPriceFormatted;?></div>
                                        <div class="LF-address">
                                            <?php echo $propertyList->FullAddress;
						if (!empty($propertyList->BuildingAreaTotal) && !empty($propertyList->BuildingAreaUnits)) {?>
                                            <p><?php echo $propertyList->BuildingAreaTotal.' '.$propertyList->BuildingAreaUnits?></p>
					<?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    if(!empty($_SESSION[$slugVariable]['style']) and $_SESSION[$slugVariable]['style'] == 'horizontal'){
                        echo '</div>';
                    }
                    echo '<div class="clear"></div>';
                    echo '<div class="LF-col-md-7">';
                    if((empty($_SESSION[$slugVariable]['pagination']) || $_SESSION[$slugVariable]['pagination'] == 'yes') and $_SESSION[$slugVariable]['style'] != 'horizontal'){
                        echo $html;
                    }
                    echo '</div>';
                    if((empty($_SESSION[$slugVariable]['priceorder']) && LF_get_settings('LF_show_priceOrder')=='yes') || ( !empty($_SESSION[$slugVariable]['priceorder']) && $_SESSION[$slugVariable]['priceorder']!='no')){
                        echo '<div class="LF-col-md-5">
                        <div class="LF-sortblock">
                        <label>Order by price: </lable>
                        Low <input type="radio" class="LF-Bsort" name="LF-Bsort" id="Basc" value="ASC" '.$ascchecked.'>
                        High <input type="radio" class="LF-Bsort" name="LF-Bsort" id="Bdesc" value="DESC" '.$descchecked.'>
                        </div>
                        </div>';
                    }
                }
                else{
                    echo '<div class="LF-col-md-12"><p>Sorry, your search did not return any results. Please try again with different search parameters.</p></div>';
                }
            }
        }?>
    </div>
</div>
