jQuery(document).ready(function() {

	jQuery(document).on('keypress', '.select2-search__field', function () {
		jQuery(this).val(jQuery(this).val().replace(/[^\d].+/, ""));
		if ((event.which < 48 || event.which > 57)) {
			event.preventDefault();
		}
	});

	setTimeout(function()
	{
		jQuery(".LF-listigs").each(function(index) {
			loadProperties('',++index);

		});
	}, 1000);

	setTimeout(function()
        {
			jQuery('#LF-loading-img').hide();
        }, 10000);

	var maxHeight = 0;

	jQuery(".LF-address").each(function() {
		if (jQuery(this).height() > maxHeight) { maxHeight = jQuery(this).height(); }
	});

	jQuery(".LF-address").height(maxHeight);
});
var noofcol = jQuery('#noofcol').val();
var per_row = jQuery('#per_row').val();
var recentPriceorder = '';
var waterfront = '';
if(per_row==''){
	noofcol = noofcol;
}
else{
	noofcol = per_row;
}
if(noofcol>4){
	noofcol = 4;
}
var options = {
	cellAlign: 'left',
	contain: true,
	pageDots: false
}

//listing pagination and sort ajax
jQuery(document).on('click', '.LF-pagination>li>a', function() {
	var pageNo = jQuery(this).attr('data-page');
	 var id = jQuery(this).closest('.LF-listigs').attr('id');
        var index = id.split("-").pop();
	loadProperties(pageNo, index);
});

jQuery(document).on('click', '#waterfront',function(){
	var waterfrontCurrValue = jQuery('input[name="waterfront"]:checked').val();
	if(typeof waterfrontCurrValue !== 'undefined' && waterfrontCurrValue == 'y') {
		waterfront='yes';
	} else {
		waterfront='no';
	}
	 var id = jQuery(this).closest('.LF-listigs').attr('id');
        var index = id.split("-").pop();
	loadProperties('',index);
});


function setRecentPriceOrder(LF_sort)
{
	if (jQuery.trim(LF_sort) == '' || typeof LF_sort == 'undefined')
	{
		recentPriceorder = '';
	}
	else if (jQuery.trim(LF_sort) != '' && typeof LF_sort !== 'undefined' && LF_sort.is(":checked"))
	{
		recentPriceorder = 'down';
	}
	else {
		recentPriceorder = 'up';
	}
}

jQuery(document).on('click', '.LF-Bsort', function() {
	var LF_sort = jQuery("#Basc");
	setRecentPriceOrder(LF_sort);
	 var id = jQuery(this).closest('.LF-listigs').attr('id');
        var index = id.split("-").pop();
	loadProperties('',index);
});

jQuery(document).on('click', '.LF-sort', function() {
	var LF_sort = jQuery("#asc");
	setRecentPriceOrder(LF_sort);
	 var id = jQuery(this).closest('.LF-listigs').attr('id');
        var index = id.split("-").pop();
	loadProperties('',index);
});

jQuery(document).on('click', '.LF-btn-search', function() {
	var id = jQuery(this).closest('.LF-listigs').attr('id');
	var index = id.split("-").pop();
	loadProperties('-2',index);
});

function loadProperties(pageNo,index)
{
	var parentDefaultId='#listing-default-'+index;
	var parentId = '#listing-'+index;
	var main_search = jQuery(parentId+' #LF_main_search').val();
	var LF_municipalities = jQuery(parentId+' #LF_municipalities').val();
	var LF_sale = jQuery(parentId+' #LF_sale').val();
	var LF_bedroom = jQuery(parentId+' #LF_bedroom').val();
	var LF_bathroom = jQuery(parentId+' #LF_bathroom').val();

	var LF_property_search = jQuery(parentId+' #LF_property_search').val();
	var LF_pricefrom_search = jQuery(parentId+' #LF_pricefrom_search').val();
	var LF_priceto_search = jQuery( parentId+' #LF_priceto_search').val();
	var LF_defaultagents = jQuery(parentDefaultId+' #defaultagents').val();
	var LF_defaultoffice = jQuery(parentDefaultId+' #defaultoffice').val();
	var LF_defaultopenhouse = jQuery(parentDefaultId+' #defaultopenhouse').val();
	var slug = jQuery(parentDefaultId+ ' #pageSlug').val();
	var tagSearch = jQuery(parentDefaultId+' #search').val();
	var tagStyle = jQuery(parentDefaultId+' #style').val();
	var tagids = jQuery(parentDefaultId+' #ids').val();
	var pagination = jQuery(parentDefaultId+' #pagination').val();
	var priceorder = jQuery(parentDefaultId+' #priceorder').val();
	var LF_per_row = jQuery(parentDefaultId+' #per_row').val();
	var LF_list_per_page = jQuery(parentDefaultId+ ' #list_per_page').val();
	var flag = 0;


	var search, municipalities, sale, bedroom, bathroom, property_Type, priceFrom, priceTo, waterFront, LF_sort, defaultoffice, defaultagents, defaultopenhouse,srch,style,ids,pagi,priord, per_row, list_per_page;


	if(jQuery.trim(LF_per_row) !='' && typeof LF_per_row !== 'undefined'){
		per_row = '&per_row='+LF_per_row;
	}
	else{
		per_row = '';
	}

	if(jQuery.trim(LF_list_per_page) !=''){
		list_per_page = '&list_per_page='+LF_list_per_page;
	}
	else{
		list_per_page = '';
	}

	if(jQuery.trim(pagination) != '' && typeof pagination !== 'undefined') {
		pagi = '&pagination='+pagination;
	}
	else{
		pagi = '';
	}

	sort='';
	if (recentPriceorder == 'up')
	{
		sort = '&priceorder=up';
	} else if (recentPriceorder == 'down'){
		sort = '&priceorder=down';
	}

	if(jQuery.trim(tagSearch) != '' && typeof tagSearch !== 'undefined') {
		srch = '&seearch='+tagSearch;
	}
	else{
		srch = '';
	}

	if(jQuery.trim(tagStyle) != '' && typeof tagStyle !== 'undefined') {
		style = '&style='+tagStyle;
	}
	else{
		style = '';
	}
	if(jQuery.trim(tagids) != '' && typeof tagids !== 'undefined') {
		ids = '&ids='+tagids;
	}
	else{
		ids = '';
	}

	if(jQuery.trim(LF_defaultopenhouse) !=''){
		defaultopenhouse = '&openhouse='+LF_defaultopenhouse;
	}
	else{
		defaultopenhouse = '';
	}
	if(jQuery.trim(LF_defaultoffice) != '' && typeof LF_defaultoffice !== 'undefined'){
		defaultoffice = '&offices='+ LF_defaultoffice;
	}
	else{
		defaultoffice = '';
	}
	if(jQuery.trim(LF_defaultagents)!='' && typeof LF_defaultagents !== 'undefined'){
		defaultagents = '&agents=' + LF_defaultagents;
	}
	else{
		defaultagents = '';
	}

	if (jQuery.trim(LF_municipalities) != '' && typeof LF_municipalities !== 'undefined') {
		municipalities = '&LF_municipalities=' + LF_municipalities;
	} else {
		var defaultlocation = jQuery(parentDefaultId+' #defaultlocation').val();
		if(defaultlocation!='' && tagSearch=='no'){
			municipalities = '&LF_municipalities=' + defaultlocation;
		}
		else{
			municipalities = '';
		}
	}

	if (jQuery.trim(main_search) != '' && typeof main_search !== 'undefined') {
		if((main_search.length<2 || main_search.length>20) && main_search!=''){
			jQuery('.formmessage').html('<div class="alert-error">Search should be 2 to 20 characters long.</div>');
			flag++;
		}
		else{
			jQuery('.formmessage').html('');
		}
		search = '&mainSearch=' + main_search;
	} else {
		search = '';
	}

	if (jQuery.trim(LF_sale) != '' && typeof LF_sale !== 'undefined') {
		sale = '&sale=' + LF_sale;
	} else {
		var defaultSale = jQuery(parentDefaultId+' #defaultsale').val();
		if(defaultSale!='' && tagSearch=='no'){
			sale =  '&sale=' +defaultSale;
		}
		else{
			sale = '';
		}
	}

	if (LF_bedroom != '' && typeof LF_bedroom !== 'undefined') {
		bedroom = '&bedroom=' + LF_bedroom;
	} else {
		bedroom = '';
	}

	if (LF_bathroom != '' && typeof LF_bathroom !== 'undefined') {
		bathroom = '&bathroom=' + LF_bathroom;
	} else {
		bathroom = '';
	}

	if (LF_property_search != '' && LF_property_search != 'undefined' && typeof LF_property_search !== 'undefined') {
		property_Type = '&property_Type=' + LF_property_search;
	}
	else
	{
		property_Type = '';
	}

	if (LF_pricefrom_search != '' && typeof LF_pricefrom_search !== 'undefined') {
		priceFrom = '&priceFrom=' + LF_pricefrom_search;
	} else {
		priceFrom = '';
	}

	if (LF_priceto_search != '' && typeof LF_priceto_search !== 'undefined') {
		priceTo = '&priceTo=' + LF_priceto_search;
	} else {
		priceTo = '';
	}

	waterFront = '';
	if (waterfront == 'yes' && typeof waterfront !== 'undefined') {
		waterFront = '&waterFront=yes';
	} else if(waterfront == 'no' && typeof waterfront !== 'undefined'){
		waterFront = '&waterFront=no';
	}

	if ((LF_pricefrom_search != '' && typeof LF_pricefrom_search !== 'undefined') && (LF_priceto_search != '' && typeof LF_priceto_search !== 'undefined')) {
		if(parseInt(LF_pricefrom_search) > parseInt(LF_priceto_search)){
			alert("Price from can't be greater then Price to.");
			return false;
		}
	}
	$dataID = jQuery('#listing-'+index);
	if(flag==0){
		jQuery.ajax({
			method: 'POST',
			url: LF_custom.ajaxurl,
			data: "action=LF_search&token=" + LF_custom.security + search + municipalities + sale + bedroom + bathroom + property_Type + priceFrom + priceTo + waterFront + sort + defaultoffice + defaultagents + defaultopenhouse + '&slug='+slug + srch + style + ids + pagi +  per_row + list_per_page+'&page='+pageNo,
			beforeSend: function() {
				$dataID.css('opacity', '0.5');
			},
			success: function(response) {
				jQuery('#listing-'+index).html(response);
				if((LF_priceto_search != '' && typeof LF_priceto_search !== 'undefined') && (jQuery('#LF_priceto_search option[value='+LF_priceto_search+']').length == 0 ))
				{
					jQuery(parentId+" #LF_priceto_search").append(new Option(LF_priceto_search,LF_priceto_search ,true, true));
				}
				if((LF_pricefrom_search != '' && typeof LF_pricefrom_search !== 'undefined') && (jQuery('#LF_pricefrom_search option[value='+LF_pricefrom_search+']').length == 0 ))
				{
					jQuery(parentId+" #LF_pricefrom_search").append(new Option(LF_pricefrom_search,LF_pricefrom_search ,true, true));
				}

				if(tagStyle == 'horizontal'){
					jQuery(".horizantal-slide").flickity(options)
				}

				 if( jQuery('.fancybox-thumbs').length ) {
							jQuery('.fancybox-thumbs').fancybox({
								prevEffect : 'none',
								nextEffect : 'none',

								closeBtn  : true,
								arrows    : true,
								nextClick : true,

								helpers : {
									thumbs : {
										width  : 50,
										height : 50
									}
								}
							});
				}

				if( jQuery('.slider-single').length ) {

						jQuery('.slider-single').slick({
							slidesToShow: 1,
							slidesToScroll: 1,
							arrows: false,
							fade: false,
							adaptiveHeight: true,
							infinite: false,
							useTransform: true,
							speed: 400,
							focusOnSelect: true,
							cssEase: 'cubic-bezier(0.77, 0, 0.18, 1)',
						});
			}

			if( jQuery('.slider-nav').length ) {
				jQuery('.slider-nav').on('init', function(event, slick) {
					jQuery('.slider-nav .slick-slide.slick-current').addClass('is-active');
				})
				.slick({
					slidesToShow: 5,
					slidesToScroll: 3,
					dots: false,
					focusOnSelect: true,
					infinite: true,
					responsive: [{
						breakpoint: 1024,
						settings: {
							slidesToShow: 4,
							slidesToScroll: 4,
						}
					}, {
						breakpoint: 640,
						settings: {
							slidesToShow: 3,
							slidesToScroll: 3,
						}
					}, {
						breakpoint: 420,
						settings: {
							slidesToShow: 2,
							slidesToScroll: 2,
						}
					}]
				});
			}

			if( jQuery('.horizantal-slide').length ) {
				jQuery('.horizantal-slide').flickity({
					// options
					cellAlign: 'left',
					contain: true,
					pageDots: false
				});
			}
			if( jQuery('.slider-single').length ) {
				jQuery('.slider-single').on('afterChange', function(event, slick, currentSlide) {
					jQuery('.slider-nav').slick('slickGoTo', currentSlide);
					var currrentNavSlideElem = '.slider-nav .slick-slide[data-slick-index="' + currentSlide + '"]';
					jQuery('.slider-nav .slick-slide.is-active').removeClass('is-active');
					jQuery(currrentNavSlideElem).addClass('is-active');
				});

			}
			if( jQuery('.slider-nav').length ) {
				jQuery('.slider-nav').on('click', '.slick-slide', function(event) {
					event.preventDefault();
					var goToSingleSlide = jQuery(this).data('slick-index');

					jQuery('.slider-single').slick('slickGoTo', goToSingleSlide);
				});
			}
			},
			complete: function() {

				var maxHeight = 0;
				jQuery(".LF-address").each(function() {
					if (jQuery(this).height() > maxHeight) { maxHeight = jQuery(this).height(); }
				});
				jQuery(".LF-address").height(maxHeight);
				jQuery('#listing-'+index).css('opacity', '1');

				jQuery(parentId+" #LF_pricefrom_search").select2( {
					placeholder: "Price From",
					allowClear: true,
					tags: true
				} ).on("change", function(e) {
					var isNew = jQuery(this).find('[data-select2-tag="true"]');
					if(isNew.length){
						jQuery(this).removeAttr('selected');
						isNew.replaceWith('<option selected value="'+isNew.val()+'">'+isNew.val()+'</option>');
					}
				}).on('select2:open', function(e){
					jQuery('.select2-search__field').attr('placeholder', 'Numbers only...');
				});
				jQuery(parentId +" #LF_priceto_search").select2( {
					placeholder: "Price To",
					allowClear: true,
					tags: true
				}).on("change", function(e) {
					var isNew = jQuery(this).find('[data-select2-tag="true"]');
					if(isNew.length){
						jQuery(this).removeAttr('selected');
						isNew.replaceWith('<option selected value="'+isNew.val()+'">'+isNew.val()+'</option>');
					}
				}).on('select2:open', function(e){
					jQuery('.select2-search__field').attr('placeholder', 'Numbers only...');
				});



			}
		});
	}
}

jQuery(document).on('submit', '#formInquiry', function() {
	var flag=0;
	var form = jQuery('#formInquiry').serialize();
	var captcha = jQuery('#recaptcha').val();
	var txtName = jQuery('#txtName').val();
	var txtemail = jQuery('#txtemail').val();
	var txtMessage = jQuery('#txtMessage').val();

	if (captcha != '' && typeof captcha !== 'undefined') {
		if(jQuery.trim(txtName)==''){
			jQuery('#txtName_error').text('Name field is required.');
			flag++;
		}
		else if(txtName.length<2 || txtName.length>20){
			jQuery('#txtName_error').text('Name should be 2 to 20 characters long.');
			flag++;
		}
		else{
			jQuery('#txtName_error').text('');
		}
		regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if(jQuery.trim(txtemail)==''){
			jQuery('#txtemail_error').text('Email field is required.');
			flag++;
		}
		else if(!regex.test(txtemail)){
			jQuery('#txtemail_error').text('This email is invalid.');
			flag++;
		}
		else{
			jQuery('#txtemail_error').text('');
		}
		if(jQuery.trim(txtMessage)==''){
			jQuery('#txtMessage_error').text('Message field is required.');
			flag++;
		}
		else if(txtMessage.length<2 || txtMessage.length>140){
			jQuery('#txtMessage_error').text('Message should be 2 to 140 characters long.');
			flag++;
		}
		else{
			jQuery('#txtMessage_error').text('');
		}

		if(grecaptcha.getResponse() == "") {
			jQuery('#recaptcha_error').text('Please select captcha.');
			flag++;
		}
		else{
			jQuery('#recaptcha_error').text('');
		}
	}

	if(flag==0){
		jQuery('.mailmessage').html('');
		jQuery.ajax({
			method: 'POST',
			url: LF_custom.ajaxurl,
			data: 'action=LF_send_inquiryMail&token=' + LF_custom.security + '&' + form,
			dataType: "json",
			success: function(result) {

				if (result.response == '1') {
					jQuery('#txtName').val('');
					jQuery('#txtemail').val('');
					jQuery('#txtMessage').val('');
					jQuery('#txtName_error').text('');
					jQuery('#txtemail_error').text('');
					jQuery('#txtMessage_error').text('');
					jQuery('.mailmessage').html('<div class="alert-success">Mail sent successfully.</div>');
				}
				else if(result.response==2){
					jQuery('#txtName_error').text(result.message.name);
					jQuery('#txtemail_error').text(result.message.email);
					jQuery('#txtMessage_error').text(result.message.message);
				}
				else{
					jQuery('#txtName_error').text('');
					jQuery('#txtemail_error').text('');
					jQuery('#txtMessage_error').text('');
					jQuery('.mailmessage').html('<div class="alert-error">Ouch!! Failed to send mail.</div>');
					jQuery('#mailsent').val('0');
				}
			}
		});
		return false;
	}
	else if(jQuery('#mailsent').val()==0){
		return false;
	}
	else{
		return false;
	}
});

function onSubmit(token) {
	jQuery("#formInquiry").submit();
}

function resetSearch(elem){

	var id = jQuery(elem).closest('.LF-listigs').attr('id');
        var index = id.split("-").pop();
	var parentId = '#listing-'+index;
	var parentDefaultId = '#listing-default-'+index;
	jQuery(parentId+" #LF_priceto_search").val('');
	if(jQuery(parentDefaultId +" #defaultwaterfront").val() == "yes")
	{
		jQuery(parentId+" #waterfront").attr("checked",true);
	}
	else
	{
		jQuery(parentId+" #waterfront").attr("checked",false);
	}

	jQuery(parentId+" #LF_pricefrom_search").val('');
	jQuery(parentId+" #LF_sale").val(jQuery("#defaultsale").val());
	jQuery(parentId+" #LF_bedroom").val(0);

	jQuery(parentId+" #LF_bathroom").val(0);
	jQuery(parentId+" #LF_property_search").val(jQuery("#search").val());
	jQuery(parentId+" #LF_main_search").val('');

	jQuery(parentId+" #LF_municipalities").val(jQuery("#defaultlocation").val());

	if(jQuery(parentId+" #priceorder").val() === "DESC")
	{
		jQuery(parentId+' #desc').prop('checked', true);
		jQuery(parentId+' #Bdesc').prop('checked', true);
	}
	else
	{
		jQuery(parentId+' #asc').prop('checked', true);
		jQuery(parentId+' #Basc').prop('checked', true);
	}

	loadProperties(-1,index);
}

jQuery(document).on('click','.LF-btn-close',function(){
	 jQuery('#Modal').hide();

});
jQuery(document).ready(function(){
	jQuery('.LF-page-title').each(function(index){
		if(index!=0){
			jQuery('.LF-page-title').eq(index).remove();
		}
	});
	jQuery('.LF-description').each(function(i){
		if(i!=0){
			jQuery('.LF-description').eq(i).remove();
		}
	});

	 if( jQuery('#LF_pricefrom_search').length ) {
		jQuery("#LF_pricefrom_search").select2( {
			placeholder: "Price From",
			allowClear: true,
			tags: true,
		});
	}

	 if( jQuery('#LF_priceto_search-0').length ) {

			jQuery("#LF_priceto_search-0").select2( {
				placeholder: "Price To",
				allowClear: true,
				tags: true,
				searchInputPlaceholder: "Numbers Only"
			});
		}
});
