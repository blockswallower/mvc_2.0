<?php

class Str {
	/**
	 * This class will contain
	 * string methods
	 */

	/**
	 * @param $string
	 * @param $char1
	 * @param $char2
	 * @return String
	 *
	 * Returns substring between 2 characters
	 */
	public static function substring($string, $char1, $char2) {
		$split = str_split($string);
		$char1_index = Arr::find_index($split, $char1);
		$char2_index = Arr::find_index($split, $char2);
		$substring = "";

		for ($ii = 0; $ii < count($split); $ii++) {
			if ($ii >= $char1_index && $ii <= $char2_index) {
				$substring .= $split[$ii];
			}
		}

		return $substring;
	}

	/**
	 * @param $string
	 * @param $index1
	 * @param $index2
	 * @return string
	 *
	 * Returns substring between 2 character indexes
     */
	public static function substringint($string, $index1, $index2) {
		$split = str_split($string);

		$substring = "";

		for ($ii = 0; $ii < count($split); $ii++) {
			if ($ii >= $index1 && $ii <= $index2) {
				$substring .= $split[$ii];
			}
		}

		return $substring;
	}

	/**
	 * @param $string
	 * @param $char
	 * @return boolean
	 *
	 * Returns true if the last character
	 * of the given string is the same as the
	 * given character
	 */
	public static function last_char($string, $char) {
		$string = str_split($string);
		$last_char = $string[count($string) -1];
		
		if ($last_char == $char) {
			return true;
		} else {
			return false;
		}
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
	public static function first_char($string, $char) {
		$string = str_split($string);
		$first_char = $string[0];

		if ($first_char == $char) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * @param $haystack
	 * @param $needle
	 * @param $checkall
	 * @return boolean
	 *
	 * Returns true if the given string
	 * contains the given substring
	 */
	public static function contains($haystack, $needle, $checkall = false) {
		/*
		 * @var string
		 */
		$contains = false;

		if (is_string($needle)) {
			if (strstr($haystack, $needle)) {
				$contains =  true;
			} else {
				return $contains;
			}
		} else if (is_array($needle) && !$checkall) {
			foreach ($needle as $check) {
				if (strstr($haystack, $check)) {
					$contains = true;
				}
			}
		} else if (is_array($needle) && $checkall) {
			$checked_needles = [];

			foreach ($needle as $check) {
				if (strstr($haystack, $check)) {
					$checked_needles[] = $check;
				}
			}

			if (Arr::size($checked_needles) == Arr::size($needle)) {
				$contains = true;
			}
		}

		return $contains;
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

	/**
	 * @param $string
	 * @return String
	 *
	 * Returns string with spaces
	 * replaced with underscores
	 */
	public static function under($string) {
		$string = str_replace(" ", "_", $string);
		return $string;
	}

	/**
	 * @param $string
	 * @param $index
	 * @return string
	 * 
	 * Returns an part of a 
	 * given string
	 */
	public static function limit($string, $index) {
		$string = str_split($string);
		$output = "";
		
		for ($ii = 0; $ii < $index; $ii++) {
			$output .= $string[$ii];		
		}
		
		return $output;
	}

	/**
	 * @return bool
	 * 
	 * Check if a string is an IP.
	 */
	public static function is_ip($string) {
		return filter_var($string, FILTER_VALIDATE_IP) !== false;
	}
	
	/**
	 * @return bool
	 * 
	 * Check if a string is an email.
	 */
	public static function is_email($string) {
		return filter_var($string, FILTER_VALIDATE_EMAIL) !== false;
	}
	
	/**
	 * @return bool
	 * 
	 * Check if a string is an url.
	 */
	public static function is_url($string) {
		return filter_var($string, FILTER_VALIDATE_URL) !== false;
	}

	/**
	 * @param $string
	 * @param $with
	 * @return string
	 * 
	 * returns 2 concatenated strings
	 */
	public static function append($string, $with) {
		return $string.$with;
	}

	/**
	 * @return String
	 *
	 * Returns random password
	 */
	public static function randomize_password() {
		$characters = array(
			'a', 'b', 'c', 'd', 'e', 'f', 'g', 
			'h', 'i', 'j', 'k', 'l', 'm', 'n',
			'o', 'p', 'q', 'r', 's', 'v', 'u',
			'v', 'w', 'x', 'y', 'z', '0', '1',
			'2', '3', '4', '5', '6', '7', '8', '9'
		); 
		
		$password = "";
		
		for ($ii = 0; $ii < 20; $ii++) {
			$password .= $characters[rand(1, 35)];
		}
		
		return $password;
	}
}
