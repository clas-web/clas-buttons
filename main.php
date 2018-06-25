<?php
/*
Plugin Name: CLAS Buttons
Plugin URI: https://github.com/clas-web/clas-buttons
Description: Displays the three CLAS buttons through a widget or shortcode.
Version: 1.1.5
Author: Crystal Barton
Author URI: https://www.linkedin.com/in/crystalbarton
GitHub Plugin URI: https://github.com/clas-web/clas-buttons
*/


require_once( __DIR__.'/control.php' );
ClasButtons_WidgetShortcodeControl::register_widget();
ClasButtons_WidgetShortcodeControl::register_shortcode();

