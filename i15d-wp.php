<?php
/*
Plugin Name: i15d WP
Plugin URI: http://g30rg3x.com/i15d-wp/
Description: i15d/i18n Permalinks for WordPress.
Version: 1.0.1
Author: g30rg3_x
Author URI: http://g30rg3x.com/
*/

/*
	Copyright 2008	g30rg3_x	(email: g30rg3x@gmail.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
	See the	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

// Anti Full-Path Disclosure
if ( !defined('ABSPATH') )
	die();

// Its just a copy from the original inside /wp-includes/formatting.php
// without the remove_accents function and chars restriction.
function i15d_wp_sanitize_title_with_dashes($title) {
	$title = strip_tags($title);
	$title = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $title);
	$title = str_replace('%', '', $title);
	$title = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $title);

	if (seems_utf8($title)) {
		if (function_exists('mb_strtolower')) {
			$title = mb_strtolower($title, 'UTF-8');
		}
		$title = utf8_uri_encode($title, 200);
	}

	$title = strtolower($title);
	$title = preg_replace('/&.+?;/', '', $title);
	$title = preg_replace('/\s+/', '-', $title);
	$title = preg_replace('|-+|', '-', $title);
	$title = trim($title, '-');

	return $title;
}

// Swaping the function sanitize_title_with_dashes with our
// custom i15d compatible.
remove_filter('sanitize_title', 'sanitize_title_with_dashes', 1);
add_filter('sanitize_title', 'i15d_wp_sanitize_title_with_dashes', 2);
?>