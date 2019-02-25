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
	'priceorder'=>''
), $atts );

$listkey = get_query_var('listkey');

if ($listkey) {
	?>
	<style>
	h1.entry-title{
		display: none;
	}
	</style>
	<?php
	$propertyDetails = getLFListingsDetails($listkey);

	if($propertyDetails->error==false){
		$propertyDetail = $propertyDetails->results;
		$propertyImages = $propertyDetail->Images;
		?>
		<h1 class="main_title"><?php echo $propertyDetail->UnparsedAddress;?></h1>
		<div class="LF-description">
			<div class="LF-row">
				<div class="LF-col-md-12">
					<a href="javascript:void(0)" onclick="window.history.back();">Back</a>
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
			<div class="LF-row">
				<div class="LF-col-md-12">
					<!-- Trigger/Open The Modal -->
					<?php if(!empty(LF_get_settings('LF_mapApiKey'))):?>
						<?php
						if(!empty($propertyDetail->Latitude) and !empty($propertyDetail->Longitude)){
							?>
							<button class="LF-btn LF-btn-map" id="myBtn">View in map</button>
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
				</div><!-- .LF-col-md-12 -->
			</div><!-- .LF-row -->
			<div class="LF-row">
				<div class="LF-col-md-6" style="text-align: center;">
					<div class="slider slider-single">
						<?php
						foreach ($propertyImages as $propertyImage) {
							$largeImage = str_replace('property/', 'property/large/', $propertyImage);
							echo '<div><a class="fancybox-thumbs" data-fancybox-group="thumb" href="'.$largeImage.'"><img src="'.$largeImage.'"></a></div>';
						}
						?>

					</div>
					<p class="LF-price">
						<?php
						if(empty($propertyDetail->Lease)){
							echo '$ ',number_format_i18n($propertyDetail->ListPrice);
						}else{
							echo '$ ',$propertyDetail->Lease,'/',$propertyDetail->LeaseTerm;
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
								<input type="text" name="txtName" id="txtName" class="LF-form-control" placeholder="Name">
							</div>
							<div class="LF-form-group">
								<input type="email" name="txtemail" id="txtemail" class="LF-form-control" placeholder="Email">
							</div>
							<div class="LF-form-group">
								<textarea name="txtMessage" id="txtMessage" rows="3" class="LF-form-control" placeholder="Message"></textarea>
							</div>
							<div class="LF-form-group">
								<button class="LF-btn send_inquiry_mail" type="button">Send</button>
							</div>
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
					<img src="<?php echo plugins_url('assets/images/realtor_logos.png',__FILE__);?>">
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
						if(!empty($propertyDetail->RoomType1)){
							echo '<li>'.$propertyDetail->RoomType1.'</li>';
							echo '<li>'.$propertyDetail->RoomLevel1.'</li>';
							echo '<li>'.$propertyDetail->RoomDimensions1.'</li>';
						}

						if(!empty($propertyDetail->RoomType2)){
							echo '<li>'.$propertyDetail->RoomType2.'</li>';
							echo '<li>'.$propertyDetail->RoomLevel2.'</li>';
							echo '<li>'.$propertyDetail->RoomDimensions2.'</li>';
						}

						if(!empty($propertyDetail->RoomType3)){
							echo '<li>'.$propertyDetail->RoomType3.'</li>';
							echo '<li>'.$propertyDetail->RoomLevel3.'</li>';
							echo '<li>'.$propertyDetail->RoomDimensions3.'</li>';
						}

						if(!empty($propertyDetail->RoomType4)){
							echo '<li>'.$propertyDetail->RoomType4.'</li>';
							echo '<li>'.$propertyDetail->RoomLevel4.'</li>';
							echo '<li>'.$propertyDetail->RoomDimensions4.'</li>';
						}

						if(!empty($propertyDetail->RoomType5)){
							echo '<li>'.$propertyDetail->RoomType5.'</li>';
							echo '<li>'.$propertyDetail->RoomLevel5.'</li>';
							echo '<li>'.$propertyDetail->RoomDimensions5.'</li>';
						}

						if(!empty($propertyDetail->RoomType6)){
							echo '<li>'.$propertyDetail->RoomType6.'</li>';
							echo '<li>'.$propertyDetail->RoomLevel6.'</li>';
							echo '<li>'.$propertyDetail->RoomDimensions6.'</li>';
						}

						if(!empty($propertyDetail->RoomType7)){
							echo '<li>'.$propertyDetail->RoomType7.'</li>';
							echo '<li>'.$propertyDetail->RoomLevel7.'</li>';
							echo '<li>'.$propertyDetail->RoomDimensions7.'</li>';
						}

						if(!empty($propertyDetail->RoomType8)){
							echo '<li>'.$propertyDetail->RoomType8.'</li>';
							echo '<li>'.$propertyDetail->RoomLevel8.'</li>';
							echo '<li>'.$propertyDetail->RoomDimensions8.'</li>';
						}

						if(!empty($propertyDetail->RoomType9)){
							echo '<li>'.$propertyDetail->RoomType9.'</li>';
							echo '<li>'.$propertyDetail->RoomLevel9.'</li>';
							echo '<li>'.$propertyDetail->RoomDimensions9.'</li>';
						}

						if(!empty($propertyDetail->RoomType10)){
							echo '<li>'.$propertyDetail->RoomType10.'</li>';
							echo '<li>'.$propertyDetail->RoomLevel10.'</li>';
							echo '<li>'.$propertyDetail->RoomDimensions10.'</li>';
						}

						if(!empty($propertyDetail->RoomType11)){
							echo '<li>'.$propertyDetail->RoomType11.'</li>';
							echo '<li>'.$propertyDetail->RoomLevel11.'</li>';
							echo '<li>'.$propertyDetail->RoomDimensions11.'</li>';
						}

						if(!empty($propertyDetail->RoomType12)){
							echo '<li>'.$propertyDetail->RoomType12.'</li>';
							echo '<li>'.$propertyDetail->RoomLevel12.'</li>';
							echo '<li>'.$propertyDetail->RoomDimensions12.'</li>';
						}

						if(!empty($propertyDetail->RoomType13)){
							echo '<li>'.$propertyDetail->RoomType13.'</li>';
							echo '<li>'.$propertyDetail->RoomLevel13.'</li>';
							echo '<li>'.$propertyDetail->RoomDimensions13.'</li>';
						}

						if(!empty($propertyDetail->RoomType14)){
							echo '<li>'.$propertyDetail->RoomType14.'</li>';
							echo '<li>'.$propertyDetail->RoomLevel14.'</li>';
							echo '<li>'.$propertyDetail->RoomDimensions14.'</li>';
						}

						if(!empty($propertyDetail->RoomType15)){
							echo '<li>'.$propertyDetail->RoomType15.'</li>';
							echo '<li>'.$propertyDetail->RoomLevel15.'</li>';
							echo '<li>'.$propertyDetail->RoomDimensions15.'</li>';
						}

						if(!empty($propertyDetail->RoomType16)){
							echo '<li>'.$propertyDetail->RoomType16.'</li>';
							echo '<li>'.$propertyDetail->RoomLevel16.'</li>';
							echo '<li>'.$propertyDetail->RoomDimensions16.'</li>';
						}

						if(!empty($propertyDetail->RoomType17)){
							echo '<li>'.$propertyDetail->RoomType17.'</li>';
							echo '<li>'.$propertyDetail->RoomLevel17.'</li>';
							echo '<li>'.$propertyDetail->RoomDimensions17.'</li>';
						}

						if(!empty($propertyDetail->RoomType18)){
							echo '<li>'.$propertyDetail->RoomType18.'</li>';
							echo '<li>'.$propertyDetail->RoomLevel18.'</li>';
							echo '<li>'.$propertyDetail->RoomDimensions18.'</li>';
						}

						if(!empty($propertyDetail->RoomType19)){
							echo '<li>'.$propertyDetail->RoomType19.'</li>';
							echo '<li>'.$propertyDetail->RoomLevel19.'</li>';
							echo '<li>'.$propertyDetail->RoomDimensions19.'</li>';
						}

						if(!empty($propertyDetail->RoomType20)){
							echo '<li>'.$propertyDetail->RoomType20.'</li>';
							echo '<li>'.$propertyDetail->RoomLevel20.'</li>';
							echo '<li>'.$propertyDetail->RoomDimensions20.'</li>';
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
			<div class="LF-disclaimer"><?php echo LF_get_settings('LF_detail_footer');?></div>
		</div><!-- .LF-description -->

		<script>
		var Latitude = <?php echo "$propertyDetail->Latitude";?>;
		var Longitude = <?php echo "$propertyDetail->Longitude";?>;
		// Initialize and add the map
		function initMap() {
			// The location of Uluru
			var uluru = {lat: Latitude, lng: Longitude};
			// The map, centered at Uluru
			var map = new google.maps.Map(
				document.getElementById('map'), {zoom: 18, center: uluru});
				// The marker, positioned at Uluru
				var marker = new google.maps.Marker({position: uluru, map: map});
			}
			</script>
			<?php
		}
		else{
			echo $propertyDetails->message;
		}
		?>
		<?php
	}
	else{
		?>
		<div id="LF-listigs">
			<?php
			if(empty($attr['search']) OR $attr['search']=='yes' OR $attr['search']=="only"):
				if(LF_get_settings('LF_show_search')=='yes'  || (($attr['search']=='yes' OR $attr['search']=='only') AND LF_get_settings('LF_show_search')!='yes')):
					?>
					<div class="LF-row">
						<form method="post" name="search">
							<div class="LF-col-md-6">
								<div class="LF-form-group">
									<input type="text" name="LF_main_search" id="LF_main_search" class="LF-form-control" placeholder="Search by Location, City, Postal Code or ID#" value="">
								</div>
							</div>
							<div class="LF-col-md-6">
								<?php
								$LF_Municipalities = explode(',',LF_get_settings('LF_Municipalities'));
								?>
								<div class="LF-form-group">
									<select name="LF_municipalities" id="LF_municipalities" class="LF-form-control">
										<option value="0">All Municipalities</option>
										<?php
										foreach($LF_Municipalities as $LF_Municipalitie):
											if($attr['location'] == $LF_Municipalitie){
												$select = "selected";
											}
											else{
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
										<option value="sale" <?php if($attr['sale']=='sale'){ echo 'selected';}?>>Sale</option>
										<option value="rent" <?php if($attr['sale']=='rent'){ echo 'selected';}?>>Rent</option>
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
										<option value="any" selected="">All Property Types</option>
										<option value="residential" <?php if($attr['type']=='residential'){ echo 'selected';}?>>Residential</option>
										<option value="commercial" <?php if($attr['type']=='commercial'){ echo 'selected';}?>>Commercial</option>
										<option value="condo" <?php if($attr['type']=='condo'){ echo 'selected';}?>>Condo/Strata</option>
										<option value="recreational" <?php if($attr['type']=='recreational'){ echo 'selected';}?>>Recreational</option>
										<option value="agriculture" <?php if($attr['type']=='agriculture'){ echo 'selected';}?>>Agriculture</option>
										<option value="land" <?php if($attr['type']=='land'){ echo 'selected';}?>>Vacant Land</option>
									</select>
								</div>
							</div>
							<div class="LF-col-md-4">
								<div class="LF-form-group">
									<select id="LF_pricefrom_search" name="LF_pricefrom_search" class="LF-form-control">
										<option value="">Price From</option>
										<option value="0" <?php if($priceFrom=='0'){ echo 'selected';}?>>0</option>
										<option value="25000" <?php if($priceFrom=='25000'){ echo 'selected';}?>>25,000</option>
										<option value="50000" <?php if($priceFrom=='50000'){ echo 'selected';}?>>50,000</option>
										<option value="75000" <?php if($priceFrom=='75000'){ echo 'selected';}?>>75,000</option>
										<option value="100000" <?php if($priceFrom=='100000'){ echo 'selected';}?>>100,000</option>
										<option value="150000" <?php if($priceFrom=='150000'){ echo 'selected';}?>>150,000</option>
										<option value="200000" <?php if($priceFrom=='200000'){ echo 'selected';}?>>200,000</option>
										<option value="250000" <?php if($priceFrom=='250000'){ echo 'selected';}?>>250,000</option>
										<option value="350000" <?php if($priceFrom=='350000'){ echo 'selected';}?>>350,000</option>
										<option value="500000" <?php if($priceFrom=='500000'){ echo 'selected';}?>>500,000</option>
										<option value="1000000" <?php if($priceFrom=='1000000'){ echo 'selected';}?>>1,000,000</option>
										<option value="5000000" <?php if($priceFrom=='5000000'){ echo 'selected';}?>>5,000,000</option>
										<option value="10000000" <?php if($priceFrom=='10000000'){ echo 'selected';}?>>10,000,000</option>
									</select>
								</div>
							</div>
							<div class="LF-col-md-4">
								<div class="LF-form-group">
									<select id="LF_priceto_search" name="LF_priceto_search" class="LF-form-control">
										<option value="">Price To</option>
										<option value="0" <?php if($priceTo=='0'){ echo 'selected';}?>>0</option>
										<option value="25000" <?php if($priceTo=='25000'){ echo 'selected';}?>>25,000</option>
										<option value="50000" <?php if($priceTo=='50000'){ echo 'selected';}?>>50,000</option>
										<option value="75000" <?php if($priceTo=='75000'){ echo 'selected';}?>>75,000</option>
										<option value="100000" <?php if($priceTo=='100000'){ echo 'selected';}?>>100,000</option>
										<option value="150000" <?php if($priceTo=='150000'){ echo 'selected';}?>>150,000</option>
										<option value="200000" <?php if($priceTo=='200000'){ echo 'selected';}?>>200,000</option>
										<option value="250000" <?php if($priceTo=='250000'){ echo 'selected';}?>>250,000</option>
										<option value="350000" <?php if($priceTo=='350000'){ echo 'selected';}?>>350,000</option>
										<option value="500000" <?php if($priceTo=='500000'){ echo 'selected';}?>>500,000</option>
										<option value="1000000" <?php if($priceTo=='1000000'){ echo 'selected';}?>>1,000,000</option>
										<option value="5000000" <?php if($priceTo=='5000000'){ echo 'selected';}?>>5,000,000</option>
										<option value="10000000" <?php if($priceTo=='10000000'){ echo 'selected';}?>>10,000,000</option>
									</select>
								</div>
							</div>
							<div class="LF-col-md-12">
								<div class="LF-form-group">
									<label id="waterfront-search" for="waterfront">
										<input id="waterfront" name="waterfront" <?php if(isset($waterFront) and $waterFront=='y'){ echo 'checked';}?> value="y" type="checkbox">Show waterfront properties only
									</label>
								</div>
								<div class="LF-form-group">
									<button class="LF-btn LF-btn-search" type="button">Search</button>
									<button class="LF-btn LF-btn-reset" type="button" onclick="resetSearch()">Reset</button>
								</div>
							</div>
						</form>
					</div>
					<?php
				endif; //end check search enable/disable from admin
			endif; //end search tag in shortcode

			$token = getToken();
			$agent_id = LF_get_settings('agent_id');
			$office_id = LF_get_settings('office_id');
			if(!empty($attr['agent'])){
				$agent = '&agents='.$attr['agent'];
			}
			else{
				$agent = '';
			}

			if(!empty($attr['office'])){
				$office = '&offices='.$attr['office'];
			}
			else{
				$office = '';
			}
			if(!empty($attr['openhouse'])){
				$openhouse = '&openhouse='.$attr['openhouse'];
			}
			else{
				$openhouse = '';
			}

			if(!empty($attr['location'])){
				$search = '&area='.urlencode($attr['location']);
			}
			else{
				$search = '';
			}

			if(!empty($attr['ids'])){
				$ids = '&ids='.$attr['ids'];
			}
			else{
				$ids = '';
			}
			if($attr['style']=='horizontal'){
				$paginate = '500';
			}
			else{
				$paginate = LF_get_settings('LF_page');
			}

			$sort = LF_get_settings('LF_priceOrder');

			if(isset($sort)){
				$sort = $sort;
			}
			else{
				$sort = 'ASC';
			}
			if(!empty($attr['sale'])){
				$sale = '&sale='.$attr['sale'];
			}
			else{
				$sale = '';
			}

			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => API_URL."/properties?token=".$token."&agent_id=".$agent_id."&office_id=".$office_id."&paginate=".$paginate."&type=".$attr['type']."&sort=".$sort.$sale.$search.$agent.$office.$ids,
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
				// echo $response;

				$page_id = get_the_ID();
				$pageSlug = get_post_field( 'post_name', $post_id );

				if(is_home() || is_front_page()){
					$option_name = 'LF-Listings';
					$postContent = LF_find_shortcode_occurencesName($option_name);
					$pageSlug = $postContent['slug'];
				}

				$result = json_decode($response);
				if(empty($result)){
					return true;
				}
				?>
				<div class="LF-row">
					<input type="hidden" name="pageSlug" id="pageSlug" value="<?php echo $pageSlug;?>">

					<input type="hidden" name="defaultSearchType" id="defaultSearchType" value="<?php echo $attr['type'];?>">

					<input type="hidden" name="defaultagents" id="defaultagents" value="<?php echo $attr['agent'];?>">

					<input type="hidden" name="defaultoffice" id="defaultoffice" value="<?php echo $attr['office'];?>">

					<input type="hidden" name="defaultlocation" id="defaultlocation" value="<?php echo $attr['location'];?>">

					<input type="hidden" name="defaultsale" id="defaultsale" value="<?php echo $attr['sale'];?>">

					<input type="hidden" name="defaultopenhouse" id="defaultopenhouse" value="<?php echo $attr['openhouse'];?>">

					<input type="hidden" name="search" id="search" value="<?php echo $attr['search'];?>">

					<input type="hidden" name="style" id="style" value="<?php echo $attr['style'];?>">
					
					<input type="hidden" name="noofcol" id="noofcol" value="<?php echo !empty(LF_get_settings('LF_column'))?LF_get_settings('LF_column'):'';?>">

					<input type="hidden" name="ids" id="ids" value="<?php echo $attr['ids'];?>">
					
					<input type="hidden" name="pagination" id="pagination" value="<?php echo $attr['pagination'];?>">
					<input type="hidden" name="priceorder" id="priceorder" value="<?php echo $attr['priceorder'];?>">

					<?php

					if(empty($attr['search']) or $attr['search']!="only" or $attr['search']=="no" or $attr['search'] == 'yes'){
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

							if(LF_get_settings('LF_priceOrder') == 'ASC'){
								$ascchecked = 'checked';
							}
							else{
								$ascchecked = '';
							}

							if(LF_get_settings('LF_priceOrder') == 'DESC'){
								$descchecked = 'checked';
							}
							else{
								$descchecked = '';
							}

							echo '<div class="LF-col-md-7">';
							if((empty($attr['pagination']) || $attr['pagination'] == 'yes') and $attr['style'] != 'horizontal'){
								echo $html;
							}
							echo '</div>';

							if(empty($attr['priceorder']) OR $attr['priceorder']=='yes'){
								if(LF_get_settings('LF_show_priceOrder')=='yes'  || (($attr['priceorder']=='yes' AND LF_get_settings('LF_show_priceOrder')!='yes'))){
								
									echo '<div class="LF-col-md-5">
									<div class="LF-sortblock">
									<label>Order by price: </lable>
									Low <input type="radio" class="LF-sort" name="LF-sort" value="ASC" '.$ascchecked.'>
									High <input type="radio" class="LF-sort" name="LF-sort" value="DESC" '.$descchecked.'>
									</div>
									</div>';
								}
							}
							echo '<div class="clear"></div>';
							//get column from admin setting
							$column = LF_get_settings('LF_column');
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
							
							if(!empty($attr['style']) and $attr['style'] == 'horizontal'){
								echo '<div class="horizantal-slide">';
							}
							foreach($result->results->data as $propertyList){
								if($col==0){
									?>
									<div class="LF-col-md-12">
										<div class="LF-listing-details LF-listview">
											<div class="LF-row">
												<div class="LF-col-md-4">
													<div class="LF-image">
														<a href="<?php echo home_url($pageSlug).'/'.$propertyList->ListingKey.'/'.$propertyList->FriendlyUrl;?>">
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
															<?php echo $propertyList->FullAddress;?>
															<p><?php echo $propertyList->BuildingAreaTotal.' '.$propertyList->BuildingAreaUnits?></p>
														</div>
														<a href="<?php echo home_url($pageSlug).'/'.$propertyList->ListingKey.'/'.$propertyList->FriendlyUrl;?>" class="LF-btn LF-btn-link">View Details</a>
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
											<div class="LF-image">
												<a href="<?php echo home_url($pageSlug).'/'.$propertyList->ListingKey.'/'.$propertyList->FriendlyUrl;?>">
													<img src="<?php echo getLFImageProxy($propertyList->ListingThumb);?>" alt="">
												</a>
											</div>
											<div class="LF-details">
												<a href="<?php echo home_url($pageSlug).'/'.$propertyList->ListingKey.'/'.$propertyList->FriendlyUrl;?>" class="LF-btn LF-btn-link">View Details</a>
												<div class="LF-price"><?php echo '$'.$propertyList->ListPriceFormatted;?></div>
												<div class="LF-address">
													<?php echo $propertyList->FullAddress;?>
													<p><?php echo $propertyList->BuildingAreaTotal.' '.$propertyList->BuildingAreaUnits?></p>
												</div>
											</div>
										</div>
									</div>
									<?php
								}
							}
							if(!empty($attr['style']) and $attr['style'] == 'horizontal'){
								echo '</div>';
							}
							echo '<div class="clear"></div>';
							echo '<div class="LF-col-md-7">';
							if((empty($attr['pagination']) || $attr['pagination'] == 'yes') and $attr['style'] != 'horizontal'){
								echo $html;
							}
							echo '</div>';
							if(empty($attr['priceorder']) OR $attr['priceorder']=='yes'){
								if(LF_get_settings('LF_show_priceOrder')=='yes'  || (($attr['priceorder']=='yes' AND LF_get_settings('LF_show_priceOrder')!='yes'))){
								
									echo '<div class="LF-col-md-5">
									<div class="LF-sortblock">
									<label>Order by price: </lable>
									Low <input type="radio" class="LF-sort" name="LF-Bsort" value="ASC" '.$ascchecked.'>
									High <input type="radio" class="LF-sort" name="LF-Bsort" value="DESC" '.$descchecked.'>
									</div>
									</div>';
								}
							}
						}
						else{
							echo '<div class="LF-col-md-12"><p>Sorry, your search did not return any results. Please try again with different search parameters.</p></div>';
						}
					}
				}?>
			</div>
			<div class="LF-disclaimer"><?php echo LF_get_settings('LF_detail_footer');?></div>
			<?php
		}
		?>
