<?php
class MyArray
{
	public static function get($array, $key, $default = NULL)
	{
		return (isset($array[$key])) ? $array[$key] : $default;
	}
	public static function checkValue($array, $key, $needle)
	{
		if (!isset($array[$key]) || $array[$key] != $needle)
		{
			return FALSE;
		}
		return TRUE;
	}
}