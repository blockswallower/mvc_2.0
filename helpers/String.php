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
}
