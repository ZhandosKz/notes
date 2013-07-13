<?php
class RegistrationForm extends CFormModel
{
	public $username;
	public $password;
	public $passwordConfirm;
	public $email;
	public $acceptRules;

	const PASSWORD_MIN_LENGTH = 6;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('username, password, passwordConfirm, email, acceptRules', 'required'),
			array('password, passwordConfirm', 'length', 'min' => self::PASSWORD_MIN_LENGTH),
			array('password, passwordConfirm', 'match', 'pattern' => '/[а-яё]/ui', 'not' => true),
			array('passwordConfirm', 'compare', 'compareAttribute' => 'password'),
			array('email', 'email'),
			array('username', 'unique', 'className' => 'User'),
			array('email', 'unique', 'className' => 'User'),
			array('acceptRules', 'boolean')
		);
	}


	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>'Remember me next time',
		);
	}

	public function register(Array $data)
	{
		$this->setAttributes($data);

		if (!$this->validate())
		{
			return FALSE;
		}

		$user = new User();
		$user->username = $this->username;
		$user->password = $this->password;
		$user->email = $this->email;

		if (!$user->save())
		{
			throw new CException('Ошибка сохранения пользователя', E_USER_ERROR);
		}

		$loginForm = new LoginForm();
		$loginForm->password = $this->password;
		$loginForm->username = $this->username;

		if (!$loginForm->validate() || !$loginForm->login())
		{
			throw new CException('Ошибка авторизации пользователя', E_USER_ERROR);
		}

		return TRUE;
	}
}