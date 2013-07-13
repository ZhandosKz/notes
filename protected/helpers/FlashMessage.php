<?php
class FlashMessage
{
	const SUCCESS = 'success';
	const ERROR = 'error';
	const WARNING = 'warning';

	private static  $_successMessages = array();
	private static  $_errorMessages = array();
	private static  $_warningMessages = array();

	public static function setSuccess($message)
	{
		self::$_successMessages[] = $message;

		Yii::app()->user->setFlash(self::SUCCESS, self::$_successMessages);
	}

	public static function setError($message)
	{
		self::$_errorMessages[] = $message;

		Yii::app()->user->setFlash(self::ERROR, self::$_errorMessages);
	}

	public static function setWarning($message)
	{
		self::$_warningMessages[] = $message;

		Yii::app()->user->setFlash(self::WARNING, self::$_warningMessages);
	}

}