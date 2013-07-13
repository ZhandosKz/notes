<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$user = User::model()->find('username = :username', array(':username' => $this->username));
		if(!$user instanceof User)
		{
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		}
		elseif(!$user->validatePassword($this->password))
		{
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		}
		else
		{
			$this->username = $user->username;
			$this->_id = $user->getPrimaryKey();
			$this->errorCode=self::ERROR_NONE;
		}

		return !$this->errorCode;
	}

	public function getId()
	{
		return $this->_id;
	}
}