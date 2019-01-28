jQuery(document).ready(function() {
    var maxHeight = 0;

    jQuery(".LF-address").each(function() {
        if (jQuery(this).height() > maxHeight) { maxHeight = jQuery(this).height(); }
    });
    jQuery(".LF-address").height(maxHeight);
    jQuery('#LF-listigs .LF-btn-search').trigger('click');
});
//listing pagination and sort ajax
jQuery(document).on('click', '.LF-sort, .LF-pagination>li>a', function() {
    var main_search = jQuery('#LF_main_search').val();
    var LF_municipalities = jQuery('#LF_municipalities').val();
    var LF_sale = jQuery('#LF_sale').val();
    var LF_bedroom = jQuery('#LF_bedroom').val();
    var LF_bathroom = jQuery('#LF_bathroom').val();
    var LF_property_search = jQuery('#LF_property_search').val();
    var LF_pricefrom_search = jQuery('#LF_pricefrom_search').val();
    var LF_priceto_search = jQuery('#LF_priceto_search').val();
    var waterfront = jQuery('input[name="waterfront"]:checked').val();
    var pageNo = jQuery(this).attr('data-page');
    var LF_sort = jQuery("input[name='LF-sort']:checked").val();
    var LF_defaultagents = jQuery('#defaultagents').val();
    var LF_defaultoffice = jQuery('#defaultoffice').val();
    var LF_defaultopenhouse = jQuery('#defaultopenhouse').val();
    var slug = jQuery('#pageSlug').val();

    var search, sale, municipalities, bedroom, bathroom, property_Type, priceFrom, priceTo, waterFront, page, LF_sort, defaultoffice, defaultagents, defaultopenhouse;

    if(jQuery.trim(LF_defaultopenhouse) !=''){
        defaultopenhouse = '&openhouse='+LF_defaultopenhouse;
    }
    else{
        defaultopenhouse = '';
    }

    if(jQuery.trim(LF_defaultoffice) != ''){
        defaultoffice = '&offices='+ LF_defaultoffice;
    }
    else{
        defaultoffice = '';
    }
    if(jQuery.trim(LF_defaultagents)!=''){
        defaultagents = '&agents=' + LF_defaultagents;
    }
    else{
        defaultagents = '';
    }
    if (jQuery.trim(LF_sort) != '' && typeof LF_sort !== 'undefined') {
        sort = '&sort=' + LF_sort;
    } else {
        sort = '&sort=ASC';
    }

    if (jQuery.trim(main_search) != '' && typeof main_search !== 'undefined') {
        search = '&mainSearch=' + main_search;
    } else {
        search = '';
    }

    if (jQuery.trim(LF_municipalities) != '0' && typeof LF_municipalities !== 'undefined') {
        municipalities = '&LF_municipalities=' + LF_municipalities;
    } else {
        var defaultlocation = jQuery('#defaultlocation').val();
        if(defaultlocation!=''){
            municipalities = '&LF_municipalities=' + defaultlocation;
        }
        else{
            municipalities = '';
        }
    }

    if (LF_sale != '0' && typeof LF_sale !== 'undefined') {
        sale = '&sale=' + LF_sale;
    } else {
        var defaultSale = jQuery('#defaultsale').val();
        if(defaultSale!=''){
           sale =  '&sale=' +defaultSale;
        }
        else{
            sale = '';
        }
    }

    if (LF_bedroom != '0' && typeof LF_bedroom !== 'undefined') {
        bedroom = '&bedroom=' + LF_bedroom;
    } else {
        bedroom = '';
    }

    if (LF_bathroom != '0' && typeof LF_bathroom !== 'undefined') {
        bathroom = '&bathroom=' + LF_bathroom;
    } else {
        bathroom = '';
    }

    if (LF_property_search != '' && typeof LF_property_search !== 'undefined') {
        property_Type = '&property_Type=' + LF_property_search;
    } else {
        var defaultType = jQuery('#defaultSearchType').val();
        if(defaultType!=''){
            property_Type = '&property_Type=' + defaultType;
        }
        else{
            property_Type = '';
        }
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

    if (waterfront == 'y' && typeof waterfront !== 'undefined') {
        waterFront = '&waterFront=' + waterfront;
    } else {
        waterFront = '';
    }

    if (pageNo != '' && typeof pageNo !== 'undefined') {
        page = '&page=' + pageNo;
    } else {
        page = '';
    }

    jQuery.ajax({
        method: 'POST',
        url: LF_custom.ajaxurl,
        data: "action=LF_pagination&token=" + LF_custom.security + page + search + municipalities + sale + bedroom + bathroom + property_Type + priceFrom + priceTo + waterFront + sort + defaultoffice + defaultagents + defaultopenhouse + '&slug='+slug,
        beforeSend: function() {
            jQuery('#LF-listigs').css('opacity', '0.5');
        },
        success: function(response) {
            jQuery('#LF-listigs').html(response);
        },
        complete: function() {
            var maxHeight = 0;
            jQuery(".LF-address").each(function() {
                if (jQuery(this).height() > maxHeight) { maxHeight = jQuery(this).height(); }
            });
            jQuery(".LF-address").height(maxHeight);
            jQuery('#LF-listigs').css('opacity', '1');
        }
    });
});

jQuery(document).on('click', '.LF-btn-search', function() {
    var main_search = jQuery('#LF_main_search').val();
    var LF_municipalities = jQuery('#LF_municipalities').val();
    var LF_sale = jQuery('#LF_sale').val();
    var LF_bedroom = jQuery('#LF_bedroom').val();
    var LF_bathroom = jQuery('#LF_bathroom').val();
    var LF_property_search = jQuery('#LF_property_search').val();
    var LF_pricefrom_search = jQuery('#LF_pricefrom_search').val();
    var LF_priceto_search = jQuery('#LF_priceto_search').val();
    var waterfront = jQuery('input[name="waterfront"]:checked').val();
    var LF_sort = jQuery("input[name='LF-sort']:checked").val();
    var LF_defaultagents = jQuery('#defaultagents').val();
    var LF_defaultoffice = jQuery('#defaultoffice').val();
    var LF_defaultopenhouse = jQuery('#defaultopenhouse').val();
    var slug = jQuery('#pageSlug').val();

    var search, municipalities, sale, bedroom, bathroom, property_Type, priceFrom, priceTo, waterFront, LF_sort, defaultoffice, defaultagents, defaultopenhouse;

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
    if (jQuery.trim(LF_sort) != '' && typeof LF_sort !== 'undefined') {
        sort = '&sort=' + LF_sort;
    } else {
        sort = '&sort=ASC';
    }

    if (jQuery.trim(LF_municipalities) != '0' && typeof LF_municipalities !== 'undefined') {
        municipalities = '&LF_municipalities=' + LF_municipalities;
    } else {
        var defaultlocation = jQuery('#defaultlocation').val();
        if(defaultlocation!=''){
            municipalities = '&LF_municipalities=' + defaultlocation;
        }
        else{
            municipalities = '';
        }
    }

    if (jQuery.trim(main_search) != '' && typeof main_search !== 'undefined') {
        search = '&mainSearch=' + main_search;
    } else {
        search = '';
    }

    if (LF_sale != '0' && typeof LF_sale !== 'undefined') {
        sale = '&sale=' + LF_sale;
    } else {
        var defaultSale = jQuery('#defaultsale').val();
        if(defaultSale!=''){
           sale =  '&sale=' +defaultSale;
        }
        else{
            sale = '';
        }
    }

    if (LF_bedroom != '0' && typeof LF_bedroom !== 'undefined') {
        bedroom = '&bedroom=' + LF_bedroom;
    } else {
        bedroom = '';
    }

    if (LF_bathroom != '0' && typeof LF_bathroom !== 'undefined') {
        bathroom = '&bathroom=' + LF_bathroom;
    } else {
        bathroom = '';
    }

    if (LF_property_search != '' && typeof LF_property_search !== 'undefined') {
        property_Type = '&property_Type=' + LF_property_search;
    } else {
        var defaultType = jQuery('#defaultSearchType').val();
        if(defaultType!=''){
            property_Type = '&property_Type=' + defaultType;
        }
        else{
            property_Type = '';
        }
1    }

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

    if (waterfront == 'y' && typeof waterfront !== 'undefined') {
        waterFront = '&waterFront=' + waterfront;
    } else {
        waterFront = '';
    }

    jQuery.ajax({
        method: 'POST',
        url: LF_custom.ajaxurl,
        data: "action=LF_search&token=" + LF_custom.security + search + municipalities + sale + bedroom + bathroom + property_Type + priceFrom + priceTo + waterFront + sort + defaultoffice + defaultagents + defaultopenhouse + '&slug='+slug,
        beforeSend: function() {
            jQuery('#LF-listigs').css('opacity', '0.5');
        },
        success: function(response) {
            jQuery('#LF-listigs').html(response);
        },
        complete: function() {
            var maxHeight = 0;
            jQuery(".LF-address").each(function() {
                if (jQuery(this).height() > maxHeight) { maxHeight = jQuery(this).height(); }
            });
            jQuery(".LF-address").height(maxHeight);
            jQuery('#LF-listigs').css('opacity', '1');
        }
    });
});
jQuery(document).on('click', '.send_inquiry_mail', function() {
    var form = jQuery('#formInquiry').serialize();
    jQuery.ajax({
        method: 'POST',
        url: LF_custom.ajaxurl,
        data: 'action=LF_send_inquiryMail&token=' + LF_custom.security + '&' + form,
        success: function(data) {
            if (jQuery.trim(data) == '1') {
                jQuery('#txtName').val('');
                jQuery('#txtemail').val('');
                jQuery('#txtMessage').val('');
                jQuery('.mailmessage').html('<div class="alert-success">Mail sent successfully.</div>');
            }
            else{
                jQuery('.mailmessage').html('<div class="alert-error">failed to mail sent.</div>');
            }
        }
    });
});
function resetSearch(){
    // location.reload();
    jQuery('.LF-row').css('opacity','0.5');
    jQuery('#LF-listigs').load(location.href+" #LF-listigs>*","");
}
jQuery(document).on('click','.btn_close_model',function(){
    jQuery.ajax({
        method: 'POST',
        url: LF_custom.ajaxurl,
        data:"action=LF_SessionStart&token=" + LF_custom.security,
        success:function(data){
            jQuery('#Modal').hide();

        }
    });
});