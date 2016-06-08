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
}