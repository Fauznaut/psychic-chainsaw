<?php
namespace core;

/**
 * Validator
 */
class Validator
{
	/**
	 * Determine if a given email is valid
	 *
	 * @param string $value The email to be validated
	 *
	 * @return boolean
	 */
	public static function email($value)
	{
		$regex = '/[a-z0-9]+[_a-z0-9\.-]*[a-z0-9]+@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})/i';
		return filter_var($value, FILTER_VALIDATE_EMAIL) && preg_match($regex, $value);
	}

	/**
	 * Determine if a given integer is valid
	 *
	 * @param integer $value The integer to be validated
	 *
	 * @return boolean
	 */
	public static function int($value)
	{
		$regex = '/^\d+$/';
		return filter_var($value, FILTER_VALIDATE_INT) && preg_match($regex, $value);
	}

	/**
	 * Determine if a given string is valid
	 *
	 * @param string $value The string to be validated
	 *
	 * @return boolean
	 */
	public static function string($value)
	{
		return is_string($value);
	}
}

