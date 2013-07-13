<?php
class ApiNote extends Note
{

	public static function getAll(Array $notes)
	{
		$result = array();
		foreach ($notes as $note)
		{
			$result[] = self::updateStatus($note);
		}
		return $result;
	}

	public static function updateStatus(Note $note)
	{
		$note->status = Note::STATUS_CLOSED;
		if (!$note->save())
		{
			throw new CException('Ошибка обновления статуса', E_USER_ERROR);
		}
		return self::getData($note);
	}

	public static function saveNote(Note $note, Array $data, $user)
	{
		if ($note->isNewRecord)
		{
			$note->setScenario('create');
		}
		else
		{
			$note->setScenario('update');
		}

		if (!empty($user))
		{
			$note->user_id = $user->getPrimaryKey();
		}

		$note->setAttributes((empty($data)) ? array() : $data);
		if (!$note->save())
		{
			throw new CException('Ошибка сохранения', E_USER_ERROR);
		}
		$note->saveUrl();
		return self::getData($note);
	}

	private static function getData(Note $note)
	{
		return array(
			'id' => $note->getPrimaryKey(),
			'text' => $note->text,
			'link' => Yii::app()->controller->createAbsoluteUrl('/note/default/view', array('path' => $note->url->path)),
			'status' => $note->status,
		);
	}


}