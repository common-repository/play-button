<?php
/*
Plugin Name: play-button
Plugin URI: http://www.thickthumb.com/open-source/play-button/
Description: Put a simple mp3 play button in any post
Version: 1.0
Author: Igor Prochazka
Author URI: http://www.thickthumb.com

---------------------------------------------------------------------
	This file is part of the wordpress plugin "play-button"
    Copyright (C) 2009 by Igor Prochazka

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

---------------------------------------------------------------------
*/

define( PLAY_BUTTON_PATTERN, "/\[ *play-button *: *([^\]]*) *\]/" );

function play_button_replace( $content ) {
	$content = preg_replace_callback( PLAY_BUTTON_PATTERN, "play_button_callback", $content );
	return $content;
}

function play_button_callback( $matches ) {
	$media = $matches[1];
	$path = plugin_dir_url( __FILE__ );
	if(strpos( $media, '://' ) === false) {
		if( $media[0] != '/' )
			$media = '/' . $media;
		$media = get_option('home') . $media; 
	}
	
	return "<object type=\"application/x-shockwave-flash\"
		data=\"{$path}/musicplayer.swf?&autoload=false&song_url={$media}\" 
		width=\"17\" height=\"17\">
		<param name=\"movie\" 
		value=\"{$path}/musicplayer.swf?&autoload=false&song_url={$media}\" />
		<img src=\"noflash.gif\" 
		width=\"17\" height=\"17\" alt=\"\" />
		</object>";
}


/* register filter hook */

add_filter('widget_text', 'play_button_replace');
add_filter('the_content', 'play_button_replace');

?>
