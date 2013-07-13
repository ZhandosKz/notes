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
			$this->body = ApiNote::create(array(
				'key' => MyArray::get($_GET, 'key'),
				'data' => array(
					'text' => MyArray::get($_GET, 'text'),
					'email' => MyArray::get($_GET, 'email'),
					'reference' => MyArray::get($_GET, 'reference')
				)
			));
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
	public function actionUpdate($key = NULL)
	{

	}
}