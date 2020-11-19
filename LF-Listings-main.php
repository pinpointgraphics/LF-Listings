<?php

if (!empty($_SESSION['listkey']))
{
	if($slugVariable != 'wp-admin-1' && (!isset($_SESSION['acceptTerms']) || $_SESSION['acceptTerms']!=$_SERVER['REMOTE_ADDR']))
	{
		if(!empty(LF_get_settings('termsandcondition')))
		{
			function add_terms_modal(){
				?>
				<!-- The Modal -->
				<div id="Modal" class="modal">
					<!-- Modal content -->
					<div class="modal-content">
						<div class="modal-header">
							<h1>Terms of Use for CREA® DDF®</h1>
						</div>
						<div class="modal-body">
							<?php echo stripslashes_deep(LF_get_settings('termsandcondition'))?>
						</div>
						<div class="modal-footer">
							<button type="button" class="LF-btn LF-btn-close" data-dismiss="modal">Dismiss</button>
						</div>
					</div>
				</div>
				<div id="agreementConsent" style="display:block;">
					<center>By using our site, you agree to our <div id="showagreementModal">Terms of Use.</div><div id="closeagreementConsent">Dismiss</div></center>
				</div>
				<script>
				jQuery( "#closeagreementConsent" ).click(function() {
					jQuery.ajax({
						method: 'POST',
						url: LF_custom.ajaxurl,
						data:"action=LF_SessionStart&token=" + LF_custom.security,
						success:function(data){
							jQuery('#Modal').hide();

						}
					});
					jQuery( "#agreementConsent").hide();
				});

				jQuery( "#showagreementModal" ).click(function() {
					jQuery( "#Modal").show();
				});
				</script>
				<?php
			}
			add_terms_modal();
			add_action('wp_footer','add_terms_modal');
		}
	}

	include('LF-Listings-single.php');
}
else
{
	include('LF-Listings-gallery.php');
}
