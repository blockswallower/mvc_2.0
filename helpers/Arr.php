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
	 * @param $key
	 * @return mixed
	 *
	 * Simply returns a value based on the array/key given
	 */
	public static function get_value($array, $key) {
		return $array[$key];
	}

	/**
	 * @param $array
	 * @param $item
	 * @return bool
	 * 
	 * Returns true if the given value
	 * exists in the given array (Non assoc)
     */
	public static function contains($array, $item) {
		$contains = false;

		foreach ($array as $arr) {
			if ($arr == $item) {
				$contains = true;
			}
		}

		return $contains;
	}

	/**
	 * @param $list
	 * @return array
	 *
	 * Shuffles an array (Also for assoc)
     */
	public static function shuffle_arr($list) {
		if (!is_array($list)) {
			return $list;
		}

		if (self::is_assoc($list)) {
			$keys = array_keys($list);
			shuffle($keys);

			$random = array();
			foreach ($keys as $key) {
				$random[$key] = $list[$key];
			}

			return $random;
		} else {
			$random = shuffle($list);
			return $random;
		}
	}

	/**
	 * @param $array
	 * @return int
	 *
	 * Returns the size of the given array
     */
	public static function size($array) {
		$size = 0;

		if (!empty($array)) {
			foreach ($array as $arr) {
				$size ++;
			}

			return $size;
		} else {
			return $size;
		}
	}

	/**
	 * @param $array
	 * @return mixed
	 *
	 * Returns random index from given array (Non assoc)
     */
	public static function rand($array) {
		$random = rand(0, self::size($array) - 1);
		return $array[$random];
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

	/**
	 * @param $array
	 * @param $item
	 * @return int|null
	 *
	 * Algorithm to find array index by given array
	 */
	public static function find_index($array, $item) {
		$index = null;

		for ($ii = 0; $ii < count($array); $ii++) {
			if ($array[$ii] == $item) {
				return $ii;
			}
		}

		return $index;
	}
}