<?php
/**
 * @copyright  Copyright (c) (http://www.winterinfotech.com)
 * @license    http://www.winterinfotech.com/license/
 * @author         Webibazaar
 * @version        Release: 1.0
 */

if ( ! function_exists( 'wntr_child_scripts' ) ) :
function wntr_child_scripts() {
    wp_enqueue_style( 'megamall-child-style', get_template_directory_uri(). '/style.css');	
}
endif;
add_action( 'wp_enqueue_scripts', 'wntr_child_scripts' );

if ( ! function_exists( 'wntr_child_resscripts' ) ) :
function wntr_child_resscripts() {
    wp_enqueue_style( 'megamall-child-resstyle', get_template_directory_uri(). '/responsive.css');	
}
endif;
add_action( 'wp_enqueue_scripts', 'wntr_child_resscripts' );
add_filter( 'woocommerce_ship_to_different_address_checked', '__return_true' );

// Change words Ship to a different address
add_filter( 'gettext', 'translate_reply' );
add_filter( 'ngettext', 'translate_reply' );

function translate_reply($translated) {
	$translated = str_ireplace( 'Ship to a different address?', 'SHIPPING DETAILS', $translated);
	return $translated;
}


add_filter( 'wp_nav_menu_items', 'my_account_loginout_link', 10, 2 );
/**
* Add WooCommerce My Account Login/Logout to Registered Menu
*
* @link https://support.woothemes.com/hc/en-us/articles/203106357-Add-Login-Logout-Links-To-The-Custom-Primary-Menu-Area
*/
function my_account_loginout_link( $items, $args ) {
   if (is_user_logged_in() && $args->primary-menu == 'primary') { //change your theme registered menu name to suit
       $items .= '<li><a href="'. wp_logout_url( get_permalink( wc_get_page_id( 'shop' ) ) ) .'">Log Out</a></li>'; //change logout link, here it goes to 'shop', you may want to put it to 'myaccount'
   }
   elseif (!is_user_logged_in() && $args->primary-menu == 'primary') {//change your theme registered menu name to suit
       $items .= '<li><a href="' . get_permalink( wc_get_page_id( 'myaccount' ) ) . '">Log In</a></li>';
   }
   return $items;
}
