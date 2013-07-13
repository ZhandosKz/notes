<?php
class DefaultController extends Controller
{
	public function actionIndex(){}

	public function actionView($id)
	{
		$model = Note::model()->findByPk($id);

		$model->status = Note::STATUS_CLOSED;
		$model->update();
		$this->render('view', array(
			'model' => $model
		));
	}

	public function actionAdd()
	{
		$model = new Note('create');

		$request = Yii::app()->request;

		if ($request->isPostRequest)
		{
			$model->setAttributes($request->getPost(get_class($model)));
			if ($model->save())
			{
				$model->saveUrl();
				$this->redirect(array('complete', 'path' => $model->url->path));
			}
		}
		$this->render('create', array(
			'model' => $model
		));
	}

	public function actionComplete($path)
	{
		$this->render('complete', array(
			'path' => $path
		));
	}
}