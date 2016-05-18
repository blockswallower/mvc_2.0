<?php

class String {
	/**
	 * This class will contain
	 * string methods
	 */

	/**
	 * @param $string
	 * @param $char
	 * @return boolean
	 *
	 * Returns true if the last character
	 * of the given string is the same as the
	 * given character
	 */
	public static function lastchar($string, $char) {
		$string = str_split($string);
		$last_char = $string[count($string) -1];
		
		if ($last_char == $char) 
			return true;
		 else 
			return false;
		
	}

	/**
	 * @param $string
	 * @param $char
	 * @return boolean
	 *
	 * Returns true if the first character
	 * of the given string is the same as the
	 * given character
	 */
	public static function firstchar($string, $char) {
		$string = str_split($string);
		$first_char = $string[0];

		if ($first_char == $char)
			return true;
		else
			return false;

	}

	/**
	 * @param $string
	 * @param $substr
	 * @return boolean
	 *
	 * Returns true if the given string
	 * contains the given substring
	 */
	public static function contains($haystack, $needle) {
		if (strstr($haystack, $needle)) 
			return true;			
		else 
			return false;
	}

	/**
	 * @param $string
	 * @return String
	 *
	 * Returns string with spaces
	 * replaced with slugs
	 */
	public static function slug($string) {
		$string = str_replace(" ", "-", $string);
		return $string;
	}
}
