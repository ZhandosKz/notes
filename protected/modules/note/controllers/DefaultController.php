<?php
class DefaultController extends Controller
{
	public function actionIndex()
	{
		echo $this->createUrl('/note/default/view', array('path' => 'fdfds'));
		$this->render('index');
	}
	public function actionView($id)
	{
		echo $id;
		echo 'upi!';
	}
	public function actionAdd()
	{
		$model = new Note('create');

		$request = Yii::app()->request;

		if ($request->isPostRequest)
		{
			if ($model->saveNote($request->getPost(get_class($model))))
			{
				Note::saveUrl($model);
				//FlashMessage::setSuccess('Note create');

			}
		}

//		$this->render('create', array(
//			'model' => $model
//		));

		$this->renderPartial('//layouts/api', array('body' => 'fdfsdf', 'successMessage' => 'ok', 'failureMessage' => 'error'));
	}
}