<?php

if(($_SESSION[$slugVariable]['popup']=='yes' || $_SESSION[$slugVariable]['popup']=='') && substr($slugVariable,-1) == '0'){
	if(!isset($_SESSION['acceptTerms']) || $_SESSION['acceptTerms']!=$_SERVER['REMOTE_ADDR']){
		if(!empty(LF_get_settings('termsandcondition'))){
			function add_terms_modal(){
				?>
				<!-- The Modal -->
				<div id="Modal" class="modal" style="display: block;">
					<!-- Modal content -->
					<div class="modal-content">
						<div class="modal-header">
							<h1>Terms of Use for CREA® DDF®</h1>
						</div>
						<div class="modal-body">
							<?php echo stripslashes_deep(LF_get_settings('termsandcondition'))?>
						</div>
						<div class="modal-footer">
							<button name="acceptTermsofUse" class="btn btn_close_model">Accept Terms of Use</button>
							<button type="button" class="LF-btn LF-btn-close" data-dismiss="modal">Decline</button>
						</div>
					</div>
				</div>
				<?php
			}
			add_terms_modal();
			add_action('wp_footer','add_terms_modal');
		}
	}
}

if (!empty($_SESSION['listkey']))
{
	include('LF-Listings-single.php');
}
else
{
	include('LF-Listings-gallery.php');
}
