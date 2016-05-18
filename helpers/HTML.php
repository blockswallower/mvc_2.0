<?php

class HTML {
	/**
	 * This class will mainly be used
	 * to for simple HTML helper
	 * methods
	 */

	/**
	 * @var String
	 */
	private static $absolute_img_path = 'http://localhost/mvc_2.0/assets/img/';

	/**
	 * @param $src
	 * @param $width
	 * @param $height
	 *
	 * generates img tag
	 */
	public static function img($src, $width, $height) {
		$src = self::$absolute_img_path.$src;
		echo '<img src="'.$src.'" width="'.$width.'" height="'.$height.'">'."\t";
	}
}