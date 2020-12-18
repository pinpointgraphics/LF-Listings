
<?php

if(isset($_SESSION['propertyDetails']))
{
    $propertyDetails = $_SESSION['propertyDetails'];
    unset($_SESSION['propertyDetails']);
}
else
{
    $propertyDetails = getLFListingsDetails($listkey);
}

if($propertyDetails->error==false){

    $propertyDetail = $propertyDetails->results;
    $propertyImages = $propertyDetail->Images;
    ?>
    <h1 class="main_title LF-page-title"><?php echo $propertyDetail->UnparsedAddress;?></h1>
    <?php if(empty(LF_get_settings('LF_turn_off_map'))):?>
        <div class="LF-row">
            <div class="LF-col-md-12">
                <a href="javascript:history.back()" class="prevPage">Back</a>&nbsp;
                <!-- Trigger/Open The Modal -->
                <?php if(!empty(LF_get_settings('LF_mapApiKey'))):?>
                    <?php
                    if(!empty($propertyDetail->Latitude) and !empty($propertyDetail->Longitude)){
                        ?>
                        <button class="LF-btn LF-btn-map" id="myBtn">View on Map</button>
                    <?php }?>
                    <!-- The Modal -->
                    <div id="myModal" class="modal">
                        <!-- Modal content -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button class="close">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div id="map"></div>
                            </div>
                        </div>
                    </div>
                <?php endif?>
                <?php
                $hasOpenHouse = false;
                if (isset($propertyDetail->OpenHouseStart) && isset($propertyDetail->OpenHouseEnd))
                {
                    $hasOpenHouse = true;
                    $ostart = str_replace('/', '-', $propertyDetail->OpenHouseStart);
                    $ostop = str_replace('/', '-', $propertyDetail->OpenHouseEnd);
                    $opening_date = new DateTime($ostart);
                    $ending_date=new DateTime($ostop);
                    $current_date = new \DateTime();
                    $current_date->sub(new DateInterval("PT5H"));
                    if ($ending_date >= $current_date)
                    {
                        ?>	<button class="LF-btn LF-btn-map" id="openHouseBtn" style="float:right">Next Openhouse <?php echo $opening_date->format('M').' '.$opening_date->format('d'); ?></button>

                        <!-- The Modal -->
                        <div id="openHouseModal" class="modal">
                            <!-- Modal content -->
                            <div class="modal-content" style="height: 200px;width: 200px;background-color: transparent;border: none;box-shadow: none;margin-top:15%">
                                <div class="modal-header">
                                    <button class="close" id="openHouseClose">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <img src=<?php echo plugins_url('assets/images/calendar.svg',__FILE__); ?> style="height: 200px;" alt="">
                                    <div class ="openHouseTextCon">
                                        <div class="openHouseNumber"> <?php echo $opening_date->format('M').' '.$opening_date->format('d'); ?></div>
                                        <div class="openHouseNumber"><?php echo $opening_date->format('g').' '.$opening_date->format('A').'-'.$ending_date->format('g').' '.$ending_date->format('A'); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php

                    }
                }
                if(isset($propertyDetail->LiveStreamStartDateTime) && isset($propertyDetail->LiveStreamEndDateTime))
                {
                    $hasOpenHouse = true;
                    $ostart = str_replace('/', '-', $propertyDetail->LiveStreamStartDateTime);
                    $ostop = str_replace('/', '-', $propertyDetail->LiveStreamEndDateTime);
                    $opening_date = new DateTime($ostart);
                    $ending_date=new DateTime($ostop);
                    $current_date = new \DateTime();
                    $current_date->sub(new DateInterval("PT5H"));
                    if ($ending_date >= $current_date)
                    {
                        ?>      <button class="LF-btn LF-btn-map" id="openHouseBtn" style="float:right">Next Live Stream <?php echo $opening_date->format('M').' '.$opening_date->format('d'); ?></button>

                        <!-- The Modal -->
                        <div id="openHouseModal" class="modal">
                            <!-- Modal content -->
                            <div class="modal-content" style="height: 200px;width: 200px;background-color: transparent;border: none;box-shadow: none;margin-top:15%">
                                <div class="modal-header">
                                    <button class="close" id="openHouseClose">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <img src=<?php echo plugins_url('assets/images/calendar.svg',__FILE__); ?> style="height: 200px;" alt="">
                                    <div class ="openHouseTextCon">
                                        <div class="openHouseNumber"> <?php echo $opening_date->format('M').' '.$opening_date->format('d'); ?></div>
                                        <div class="openHouseNumber"><?php echo $opening_date->format('g').' '.$opening_date->format('A').'-'.$ending_date->format('g').' '.$ending_date->format('A'); ?></div>
                                        <div class="openHousePopupText openHouseNumber"><a href=<?php echo $propertyDetail->LiveStreamURL.''; ?> target="_blank">Watch Live</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php

                    }
                }
                ?>
            </div><!-- .LF-col-md-12 -->
        </div><!-- .LF-row -->
    <?php else: ?>
        <div class="LF-row">
            <div class="LF-col-md-12">
                <a href="javascript:history.back()" class="prevPage">Back</a>
            </div>
        </div>
    <?php endif; ?>
    <div class="LF-description">
        <div class="LF-row">
            <div class="LF-col-md-12">
                <p class="image-count"><?php echo $propertyDetail->ImageCount.' Images Found';?></p>
                <div class="slider slider-nav">
                    <?php
                    foreach ($propertyImages as $propertyImage) {
                        echo '<div><img src="'.$propertyImage.'"></div>';
                    }
                    ?>
                </div>
            </div>
            <div class="LF-col-md-12">
                <div class="LF-address">
                    <p>
                        <?= $propertyDetail->FullAddress ?>
                    </p>
                    <p>
                        <?= 'ID#'. $propertyDetail->ListingId;?>
                    </p>
                </div><!-- .LF-address -->
            </div><!-- .LF-col-md-12 -->
        </div><!-- .LF-row -->
        &nbsp;
        <div class="LF-row">
            <div class="LF-col-md-6" style="text-align: center;">
                <div class="slider slider-single">
                    <?php
                    foreach ($propertyImages as $propertyImage) {
                        $largeImage = str_replace('property/', 'property/large/', $propertyImage);
                        echo '<div><a class="fancybox-thumbs" data-fancybox-group="thumb" href="'.$largeImage.'"><img height="255px" width="383px" src="'.$largeImage.'"></a></div>';
                    }
                    ?>

                </div>
                <p class="LF-price">
                    <?php
                    if(empty($propertyDetail->Lease)){
                        echo '$ ',number_format_i18n($propertyDetail->ListPrice);
                    }else{
                        $leaseTerm = empty($propertyDetail->LeaseTerm) ? $propertyDetail->LeasePerUnit : $propertyDetail->LeaseTerm;
                        if (empty($leaseTerm))
                        {
                            $leaseTerm = "square feet";
                        }
                        echo '$ ',$propertyDetail->Lease,'/',$leaseTerm;
                    }
                    ?>
                </p>
            </div><!-- .LF-col-md-6 -->
            <div class="LF-col-md-6">
                <div class="LF-inquiry-details">
                    <div class="mailmessage"></div>
                    <form method="post" name="formInquiry" id="formInquiry">
                        <div class="LF-form-group">
                            <input type="text" name="txtSubject" id="txtSubject" class="LF-form-control" placeholder="" value="ID#<?php echo $propertyDetail->ListingId;?>" readonly>
                        </div>
                        <div class="LF-form-group">
                            <input type="text" name="txtName" id="txtName" class="LF-form-control" placeholder="Name" minlength="2" maxlength="20">
                            <label for="" class="alert-error" id="txtName_error"></label>
                        </div>
                        <div class="LF-form-group">
                            <input type="email" name="txtemail" id="txtemail" class="LF-form-control" placeholder="Email">
                            <label for="" class="alert-error" id="txtemail_error"></label>
                        </div>
                        <div class="LF-form-group">
                            <textarea name="txtMessage" id="txtMessage" rows="3" class="LF-form-control" placeholder="Message" minlength="2" maxlength="140"></textarea>
                            <label for="" class="alert-error" id="txtMessage_error"></label>
                        </div>
                        <input type="hidden" id="listingURL" name="listingURL" value='<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>'>
                        <?php
                        if(!empty(LF_get_settings('LF_reCaptcha')) and LF_get_settings('LF_reCaptchastate')!='no-captch'){
                            if(LF_get_settings('LF_reCaptchastate')=='yes'){
                                ?>
                                <div class="LF-form-group">
                                    <div class="g-recaptcha" data-sitekey="<?php echo LF_get_settings('LF_reCaptcha');?>"></div>
                                    <input type="hidden" name="recaptcha" id="recaptcha" value="yes">
                                    <label for="" class="alert-error" id="recaptcha_error"></label>

                                </div>
                                <button class="LF-btn send_inquiry_mail" type="submit">Send</button>
                                <?php
                            }
                            else{
                                ?>
                                <div class="LF-form-group">
                                    <input type="hidden" name="mailsent" id="mailsent" value="">
                                    <button class="LF-btn send_inquiry_mail g-recaptcha" data-sitekey="<?php echo LF_get_settings('LF_reCaptcha');?>" data-callback='onSubmit'>Send</button>
                                </div>
                                <?php
                            }
                        }
                        else{
                            ?>
                            <button class="LF-btn send_inquiry_mail" type="submit">Send</button>
                            <?php
                        }
                        ?>
                    </form>
                </div><!-- .LF-inquiry-details -->
            </div><!-- .LF-col-md-6 -->
        </div><!-- .LF-row -->
        <div class="LF-clear"></div>

        <div class="LF-row">
            <h1>Description</h1>
            <p>
                <?= $propertyDetail->PublicRemarks;?>
            </p>
            <p>
                <a href="<?=$propertyDetail->MoreInformationLink?>" alt="Powered by: REALTOR.ca" target="_blank"> <img width="125" src="https://www.realtor.ca/images/en-ca/powered_by_realtor.svg"/></a>
            </p>
            <h1>Building</h1>
            <ul id="LF-building-details">
                <?php
                if(!empty($propertyDetail->BuildingAreaTotal)){
                    echo '<li><b>Building Area: </b>'. $propertyDetail->BuildingAreaTotal.' '. $propertyDetail->BuildingAreaUnits.'</li>';
                }

                if(!empty($propertyDetail->BathroomsTotal)){
                    echo '<li><b>Bathrooms (Total): </b>'. $propertyDetail->BathroomsTotal.'</li>';
                }
                if(!empty($propertyDetail->BathroomsHalf)){
                    echo '<li><b>Bathrooms (Partial): </b>'. $propertyDetail->BathroomsHalf.'</li>';
                }
                if(!empty($propertyDetail->BedroomsTotal)){
                    echo '<li><b>Bedrooms: </b>'. $propertyDetail->BedroomsTotal.'</li>';
                }
                if(!empty($propertyDetail->Heating)){
                    echo '<li><b>Heating: </b>'. $propertyDetail->Heating.' '.$propertyDetail->HeatingFuel.'</li>';
                }
                if(!empty($propertyDetail->Sewer)){
                    echo '<li><b>Utility Sewer: </b>'. $propertyDetail->Sewer.' '.$propertyDetail->HeatingFuel.'</li>';
                }
                ?>
            </ul>

            <h1>Details</h1>
            <ul id="LF-building-details">
                <?php
                if(!empty($propertyDetail->ArchitecturalStyle)){
                    echo '<li><b>Architectural Style: </b>'. $propertyDetail->ArchitecturalStyle.'</li>';
                }
                if(!empty($propertyDetail->YearBuilt)){
                    echo '<li><b>Year Built: </b>'. $propertyDetail->YearBuilt.'</li>';
                }
                if(!empty($propertyDetail->PropertyType)){
                    echo '<li><b>Property Type: </b>'. $propertyDetail->PropertyType.'</li>';
                }
                if(!empty($propertyDetail->OwnershipType)){
                    echo '<li><b>Ownership Type: </b>'. $propertyDetail->OwnershipType.'</li>';
                }
                if(!empty($propertyDetail->Levels)){
                    echo '<li><b>Levels: </b>'. $propertyDetail->Levels.'</li>';
                }
                if(!empty($propertyDetail->GarageSpaces)){
                    echo '<li><b>Garage: </b>'. $propertyDetail->GarageSpaces.'</li>';
                }
                if(!empty($propertyDetail->FireplaceFuel)){
                    echo '<li><b>Fireplace Fuel: </b>'. $propertyDetail->FireplaceFuel.'</li>';
                }
                if(!empty($propertyDetail->Cooling)){
                    echo '<li><b>Cooling: </b>'. $propertyDetail->Cooling.'</li>';
                }
                if(!empty($propertyDetail->Flooring)){
                    echo '<li><b>Flooring: </b>'. $propertyDetail->Flooring.'</li>';
                }
                if(!empty($propertyDetail->View) and $propertyDetail->WaterfrontYN==true){
                    echo '<li><b>Waterfront: </b>'.'Yes ('.$propertyDetail->WaterBodyName.')</li>';
                }
                if(!empty($propertyDetail->View)){
                    echo '<li><b>View: </b>'.$propertyDetail->View.'</li>';
                }
                if(!empty($propertyDetail->GarageYN) and $propertyDetail->GarageYN==true){
                    echo '<li><b>View: </b>Yes</li>';
                }
                ?>
            </ul>
            <?php
            if(!empty($propertyDetail->RoomType1)){
                ?>
                <h1>Rooms</h1>
                <ul id="LF-room-details">
                    <li>
                        <b>Type</b>
                    </li>
                    <li>
                        <b>Level</b>
                    </li>
                    <li>
                        <b>Dimension</b>
                    </li>
                    <?php

			for ($x = 1; $x <= 20; $x++) {
				$roomType = "RoomType";
				$roomTypeNum =  "RoomType".$x;
				$roomLevel = "RoomLevel".$x;
				$roomDim = "RoomDimensions".$x;
  				 if(!empty($propertyDetail->$roomTypeNum)){
                	     	   echo '<li>'.$propertyDetail->$roomTypeNum.'</li>';
				if (!empty($propertyDetail->$roomLevel)){
	                        echo '<li>'.$propertyDetail->$roomLevel.'</li>'; }else { echo "Not available"; }

				if (!empty($propertyDetail->$roomDim)) {
        	                echo '<li>'.$propertyDetail->$roomDim.'</li>'; } else { echo "Measurements not available"; }
                    		}
			}

                    ?>
                </ul>
                <?php
            }
            ?>
        </div>
        <div class="detail-footer">
            <?php
            echo '<p>This listing is brought to you by '.$propertyDetail->ListOfficeName.'</p>
            <p>Provided by: '.$propertyDetail->ListAOR.'</p>';
            ?>
        </div>
    </div><!-- .LF-description -->

    <?php if(!empty($propertyDetail->Latitude) && !empty($propertyDetail->Longitude) && !empty(LF_get_settings('LF_mapApiKey'))){ ?>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo LF_get_settings('LF_mapApiKey');?>&callback&callback=initMap"></script>
        <script>
        var Latitude = <?php echo "$propertyDetail->Latitude";?>;
        var Longitude = <?php echo "$propertyDetail->Longitude";?>;
        // Initialize and add the map
        function initMap() {
            // The location of Uluru
            var uluru = {lat: Latitude, lng: Longitude};
            // The map, centered at Uluru
            var map = new google.maps.Map(document.getElementById('map'), {zoom: 18, center: uluru});
            // The marker, positioned at Uluru
            var marker = new google.maps.Marker({position: uluru, map: map});
        }

        // Get the modal
        var modal = document.getElementById('myModal');

        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal
        if (btn != null)
        {
            btn.onclick = function() {
                modal.style.display = "block";
            }
        }

        if (span != null)
        {
            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
                modal.style.display = "none";
            }
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
        </script>
    <?php } ?>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <?php if ($hasOpenHouse == true) { ?>
        <script type="text/javascript">

        // Get the modal
        var openHousemodal = document.getElementById('openHouseModal');

        // Get the button that opens the modal
        var openHousebtn = document.getElementById("openHouseBtn");

        // Get the <span> element that closes the modal
        var openHousespan = document.getElementById("openHouseClose");

        if (openHousebtn != null)
        {
            // When the user clicks the button, open the modal
            openHousebtn.onclick = function() {
                openHousemodal.style.display = "block";
            }
        }

        if (openHousespan != null)
        {
            // When the user clicks on <span> (x), close the modal
            openHousespan.onclick = function() {
                openHousemodal.style.display = "none";
            }
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == openHousemodal) {
                openHousemodal.style.display = "none";
            }
        }
        </script>
        <?php
    }
}
else{
    echo $propertyDetails->message;
}
?>
