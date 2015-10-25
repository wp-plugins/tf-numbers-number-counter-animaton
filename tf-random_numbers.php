<?php
/**
  * Plugin Name: TF Random Numbers
  * Plugin URI: http://themeflection.com/plug/number-counter-animation-wordpress-plugin/
  * Version: 1.2
  * Author: Aleksej Vukomanovic
  * Author URI: http://themeflection.com
  * Description: Random numbers plugin for WordPress
  * Text Domain: TF
  * Domain Path: /languages
  * License: GPL
  */
	// Exit if accessed directly
	if ( ! defined( 'ABSPATH' ) ) exit;

  if( !defined( 'TF_NUMBERS_VERSION' ) )
    define( 'TF_NUMBERS_VERSION', '1.0' );
  if( !defined( 'TF_NUMBERS_DIR' ) )
    define( 'TF_NUMBERS_DIR', plugin_dir_url( __FILE__ ) );

  if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
    require_once dirname( __FILE__ ) . '/cmb2/init.php';
  } elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
    require_once dirname( __FILE__ ) . '/CMB2/init.php';
  }

  require_once 'inc/font-awesome.php';
  require_once 'inc/setup.php';
  require_once 'inc/shortcode.php';
  TF_Numbers::init();  
  $shortcode = new TF_Numbers_Shortcode;
  ?>