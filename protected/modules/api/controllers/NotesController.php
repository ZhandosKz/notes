<?php
class NotesController extends ModuleController
{
	public function actionIndex()
	{
		try
		{
			$user = User::getUserByApiKey(MyArray::get($_GET, 'key'));
			$notes = Note::model()->findAll('user_id = :userId', array(':userId' => $user->getPrimaryKey()));

			$this->body = ApiNote::getAll($notes);
		}
		catch (CHttpException $e)
		{
			$this->status = $e->statusCode;
			$this->statusMessage = $e->getMessage();
		}
		catch (CException $e)
		{
			$this->status = 500;
			$this->statusMessage = $e->getMessage();
		}
	}

	public function actionView($path)
	{
		try
		{
			$note = $this->_loadModel($path);
			$this->body = ApiNote::updateStatus($note);
		}
		catch (CHttpException $e)
		{
			$this->status = $e->statusCode;
			$this->statusMessage = $e->getMessage();
		}
		catch (CException $e)
		{
			$this->status = 500;
			$this->statusMessage = $e->getMessage();
		}

	}


	public function actionCreate()
	{
		try
		{
			$apiKey = MyArray::get($_GET, 'key');
			if (!empty($apiKey))
			{
				$user = User::getUserByApiKey($apiKey);
			}

			$note = new Note('create');

			$this->body = ApiNote::saveNote($note, array(
				'text' => MyArray::get($_GET, 'text'),
				'email' => MyArray::get($_GET, 'email'),
				'reference' => MyArray::get($_GET, 'reference')
			), (!isset($user)) ? null : $user);
		}
		catch (CHttpException $e)
		{
			$this->status = $e->statusCode;
			$this->statusMessage = $e->getMessage();
		}
		catch (CException $e)
		{
			$this->status = 500;
			$this->statusMessage = $e->getMessage();
		}

	}
	public function actionUpdate($path)
	{
		try
		{
			$user = User::getUserByApiKey(MyArray::get($_GET, 'key'));
			$note = $this->_loadModel($path);
			if ($note->user_id !== $user->getPrimaryKey())
			{
				throw new CHttpException(403, 'Нет прав для редактирования');
			}
			$this->body = ApiNote::saveNote($note, array(
				'text' => MyArray::get($_GET, 'text'),
				'email' => MyArray::get($_GET, 'email'),
				'reference' => MyArray::get($_GET, 'reference')
			), $user);


		}
		catch (CHttpException $e)
		{
			$this->status = $e->statusCode;
			$this->statusMessage = $e->getMessage();
		}
		catch (CException $e)
		{
			$this->status = 500;
			$this->statusMessage = $e->getMessage();
		}
	}

	public function actionDelete($path)
	{
		try
		{
			$user = User::getUserByApiKey(MyArray::get($_GET, 'key'));
			$note = $this->_loadModel($path);
			if ($note->user_id !== $user->getPrimaryKey())
			{
				throw new CHttpException(403, 'Нет прав для редактирования');
			}
			$note->delete();

		}
		catch (CHttpException $e)
		{
			$this->status = $e->statusCode;
			$this->statusMessage = $e->getMessage();
		}
		catch (CException $e)
		{
			$this->status = 500;
			$this->statusMessage = $e->getMessage();
		}
	}
	private function _loadModel($path)
	{
		$note = Note::model()->with('url')->find('url.path = :path AND status = :status', array(':path' => $path, ':status' => Note::STATUS_OPEN));
		if (!$note instanceof Note)
		{
			throw new CHttpException(404, 'Заметка не найдена');
		}
		return $note;
	}
}