<?php
/*
Plugin Name: Lightning Fast Listings
Plugin URI: https://lightningfastlistings.ca
Description: Lightning Fast Listings is a WordPress plugin exclusively designed for Canadian Real Estate Agents who are licensed by the Canadian Real Estate Association (CREA ®) to display listings via the Data Distribution Facility (DDF ®). All real estate listings are served "lightning fast", designed and hosted remotely to not take up any of the website's own resources.
Version: 1.1
Author: Pinpoint Media Design
Author URI: https://www.pinpointmediadesign.com
License: GLP2
*/
?>
<?php

// global variables
$pluginPrefix = 'LF';
define( 'LF_PLUGIN', __FILE__ );
define( 'LF_PLUGIN_BASENAME', plugin_basename( LF_PLUGIN ) );
define( 'LF_PLUGIN_NAME', trim( dirname( LF_PLUGIN_BASENAME ), '/' ) );
define( 'LF_PLUGIN_DIR', untrailingslashit( dirname( LF_PLUGIN ) ) );
define('API_URL','https://ddf.dfiner.net/v1');

// required getpages
require_once LF_PLUGIN_DIR. '/settings.php';
require_once LF_PLUGIN_DIR. '/inc/functions.php';
require_once LF_PLUGIN_DIR. '/inc/listings.php';

/**
 * this function is called when user activates the plugin.
 * this basically prepares the database table.
 */
register_activation_hook(__FILE__,'LF_plugin_on_activation');
function LF_plugin_on_activation()
{
	//create table to store multiple information.
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix.'LF_listing_settings';

	$sql = "CREATE TABLE if not exists $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		meta_key varchar(100) NOT NULL,
		meta_value LONGTEXT NULL DEFAULT NULL,
		PRIMARY KEY  (id),
		UNIQUE (meta_key)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	$wpdb->insert(
		$table_name,
		array(
			'meta_key' => 'LF_column',
			'meta_value' => 3
		)
	);
	$wpdb->insert(
		$table_name,
		array(
			'meta_key' => 'LF_page',
			'meta_value' => 12
		)
	);
	$wpdb->insert(
		$table_name,
		array(
			'meta_key' => 'LF_show_priceOrder',
			'meta_value' => 'yes'
		)
	);
}

/**
 * this function registers the query variables so that we
 * get the them and show appropriate page.
 */
add_filter( 'query_vars', 'LF_register_query_vars' );
function LF_register_query_vars( $vars )
{
	$vars[] = 'listkey';
	return $vars;
}

/**
 * this function basically grabs the URL and convert it
 * to SEO friendly URLs for single listing page
 */
add_action('init', 'LF_plugin_init', 10, 0);
function LF_plugin_init()
{
	session_start();
	if (!isset($_SESSION['EXPIRES']))
	{
		$_SESSION['EXPIRES'] = time() + 3600;
	}
	else if(time() > $_SESSION['EXPIRES'])
	{
		unset($_SESSION['EXPIRES']);
		unset($_SESSION['acceptTerms']);
	}

	$pattern = get_shortcode_regex();
	$option_name = 'LF-Listings';
	$postContent = LF_find_shortcode_occurencesName($option_name);
	$slug = trim(getCurrentPageSlug());

	if ( preg_match_all( '/'. $pattern .'/s', $postContent['content'], $matches )
	&& array_key_exists( 2, $matches )
	&& in_array( 'LF-Listings', $matches[2] ) )
	{
		add_rewrite_rule( '^'.$slug.'/([0-9]+)/?', 'index.php?pagename='.$slug.'&listkey=$matches[1]&title=$matches[2]','top' );

		global $wp_rewrite;
		$wp_rewrite->flush_rules();
	}

	require_once( LF_PLUGIN_DIR.'/updater.php' );
	if ( is_admin() )
	{
    		new LF_Listings_Plugin_Updater( __FILE__, 'pinpointgraphics', "LF-Listings" );
	}
}
?>
