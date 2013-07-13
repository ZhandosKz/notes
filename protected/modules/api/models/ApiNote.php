<?php
class ApiNote extends Note
{

	public static function getAll($key = 1)
	{
		$notes = self::model()->with('user')->findAll('user.api_key = :apiKey', array(':apiKey' => $key));
		$result = array();
		foreach ($notes as $note)
		{
			$result[] = self::setItem($note);
		}

		return json_encode($result);
	}

	public static function get($path)
	{
		$note = self::model()->with('url')->find('url.path = :path', array(':path' => $path));
		if (!$note instanceof Note)
		{
			throw new CHttpException(404);
		}
		return json_encode(self::setItem($note));
	}

	private static function setItem(Note $note)
	{
		return array(
			'id' => $note->getPrimaryKey(),
			'text' => $note->text,
			'link' => Yii::app()->controller->createAbsoluteUrl('/note/default/view', array('path' => $note->url->path)),
			'status' => $note->status,
		);
	}
}