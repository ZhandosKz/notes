<?php

class AuthController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}


	public function actionIndex()
	{
		$this->redirect('/');
	}


	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		$request = Yii::app()->request;

		if($request->getIsAjaxRequest() && MyArray::checkValue($_POST, 'ajax', 'login_form'))
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}


		if($request->getIsPostRequest())
		{
			$model->attributes = $request->getPost(get_class($model));

			if($model->validate() && $model->login())
			{
				FlashMessage::setSuccess('Добро пожаловать!');
				$this->redirect(Yii::app()->user->returnUrl);
			}

		}
		$this->render('login', array(
			'model'=>$model
		));
	}

	public function actionRegister()
	{
		$form = new RegistrationForm();

		$request = Yii::app()->request;

		if ($request->getIsAjaxRequest() && $_POST['ajax'] === 'registration_form')
		{
			echo CActiveForm::validate($form);
			Yii::app()->end();
		}

		if ($request->getIsPostRequest())
		{
			if ($form->register($request->getPost(get_class($form))) === TRUE)
			{
				FlashMessage::setSuccess('Вы успешно зарегистрированы');
				$this->redirect('/');
			}
		}

		$this->render('register', array(
			'model' => $form
		));
	}

	public function actionLogout()
	{
		Yii::app()->user->logout();
		FlashMessage::setSuccess('Вы вышли');
		$this->redirect(Yii::app()->homeUrl);
	}
}