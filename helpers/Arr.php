<?php

class Arr {
	/**
	 * This class will contain
	 * array methods
	 */

	/**
	 * @param $array
	 * @return array
	 *
	 * Returns first array item
	 * of the given array
	 */
	public static function first($array) {
		return $array[0];
	}

	/**
	 * @param $array
	 * @return array
	 *
	 * Returns last array item
	 * of the given array
	 */
	public static function last($array) {
		return $array[count($array) -1];
	}

	/**
	 * @param $array
	 * @return bool
	 * 
	 * Returns true if the given array is associative
	 */
	public static function is_assoc($array) {
		$isAssoc = false;

		if (!empty($array) && is_array($array)) {
			$isAssoc = (bool) count(array_filter(array_keys($array), 'is_string'));
		}
		
		return $isAssoc;
	}
}