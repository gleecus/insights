<?php add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'child-style', get_stylesheet_uri(), array( 'bootstrap', 'parent-style' ) );
    wp_enqueue_style( 'dynamic-css', get_stylesheet_directory_uri() . '/dynamic.css' );
}
add_action( 'wp_enqueue_scripts', 'wntr_child_resscripts' );
add_filter( 'woocommerce_ship_to_different_address_checked', '__return_true' );
// Change words Ship to a different address
add_filter( 'gettext', 'translate_reply' );
add_filter( 'ngettext', 'translate_reply' );
function translate_reply($translated) {
	$translated = str_ireplace( 'Ship to a different address?', 'SHIPPING DETAILS', $translated);
	return $translated;
}
function redirect_login_page(){
       if(is_user_logged_in()){
                return;
       }
       global $post;
       // Store for checking if this page equals wp-login.php
       // permalink to the custom login page
       // $login_page  = get_permalink( 'login' );
       $login_page  = get_permalink( '11252' );
       if( has_shortcode($post->post_content, "woocommerce_my_account") ) {
           wp_redirect( $login_page );
           exit();
       }
   }
add_action( 'template_redirect','redirect_login_page' );
// 13-Nov-2019
add_filter( 'wp_nav_menu_items', 'add_loginout_link', 10, 2 );
function add_loginout_link( $items, $args ) {
  if (is_user_logged_in() && $args->theme_location == 'primary_navigation') {
      //echo "hello friend how are";
      $items .= '<li><a href="'. wp_logout_url( get_permalink( woocommerce_get_page_id( 'myaccount' ) ) ) .'">Log Out</a></li>';
  }
  elseif (!is_user_logged_in() && $args->theme_location == 'primary_navigation') {
      $items .= '<li><a href="' . get_permalink( woocommerce_get_page_id( 'myaccount' ) ) . '">Log In</a></li>';
  }
  return $items;
}

// 4-Dec-2019
add_filter( 'the_title', 'shorten_woo_product_title', 10, 2 );
function shorten_woo_product_title( $title, $id ) {
    if ( ! is_singular( array( 'product' ) ) && get_post_type( $id ) === 'product' ) {
       return substr( $title, 0, 27).'...'; // change last number to the number of characters you want	
    } else {
        return $title;
    }
}
