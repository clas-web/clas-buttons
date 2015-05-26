<?php
/*
Plugin Name: CLAS Buttons
Plugin URI: 
Description: Displays the three CLAS buttons through widget or shortcode.
Version: 1.0.0
Author: Crystal Barton
Author URI: 
*/


require_once( dirname(__FILE__).'/control.php' );
ClasButtons_WidgetShortcodeControl::register_widget();
ClasButtons_WidgetShortcodeControl::register_shortcode();

