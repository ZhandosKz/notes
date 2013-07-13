<?php
class NotesController extends ModuleController
{
	public function actionIndex()
	{
		$this->body = ApiNote::getAll(MyArray::get($_GET, 'key'));
	}

	public function actionView($path)
	{
		try
		{
			$this->body = ApiNote::get($path);
		}
		catch (CHttpException $e)
		{
			$this->status = $e->statusCode;
		}
		catch (CException $e)
		{
			$this->status = 500;
		}
	}

	public function actionCreate($key = NULL)
	{

	}
	public function actionUpdate($key = NULL)
	{

	}
}