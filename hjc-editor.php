<?php
/*
Plugin Name: HCJ Code Editor
Plugin URI: http://wpamanuke.com/hcj-code-editor-wp-plugin/
Description: HCJ Code Editor WordPress Plugin is a plugin which  allows you to write HTML, CSS, and JavaScript in realtime and preview the results on the same page. It’s almost same as JSFiddle or Codepen , but more simple. I made it for my collection HTML , CSS , JS Code and practicing my programming. Also i want to organize my simple code based on category and modify the theme. Just use in localhost only.
Version: 1.0.1
Author: WPAmaNuke
Author URI: http://wpamanuke.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2018 WPAmaNuke
*/

if ( !defined( 'ABSPATH' ) ) exit;

define('hjc_CODE_URL',plugin_dir_url( __FILE__ ));


// Admin Options
require_once( dirname( __FILE__ ) . '/class-hjc-editor.php');
require_once ( dirname( __FILE__ ) . '/admin/hjc-editor-options.php' );
