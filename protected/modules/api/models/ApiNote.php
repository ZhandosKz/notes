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

		return $result;
	}

	public static function get($path)
	{
		$note = self::model()->with('url')->find('url.path = :path AND status = :status', array(':path' => $path, ':status' => Note::STATUS_OPEN));
		if (!$note instanceof Note)
		{
			throw new CHttpException(404, 'Заметка не найдена');
		}
		$note->status = Note::STATUS_CLOSED;
		if (!$note->save())
		{
			throw new CException('Ошибка обновления статуса', E_USER_ERROR);
		}
		return self::setItem($note);
	}

	public static function create(Array $data)
	{
		$note = new Note('create');

		$note->setAttributes((empty($data['data'])) ? array() : $data['data']);
		if (!$note->save())
		{
			throw new CException('Ошибка сохранения', E_USER_ERROR);
		}
		$note->saveUrl();
		return self::setItem($note);

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