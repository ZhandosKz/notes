<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $salt
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, email', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, password, email', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Username',
			'password' => 'Password',
			'email' => 'Email',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function hashPassword($password, $salt)
	{
		return md5($password.$salt);
	}

	public function validatePassword($password)
	{
		return ($this->password === self::hashPassword($password, $this->salt)) ? TRUE : FALSE;
	}
	public static function getSalt($length = 32)
	{
		$chars = "abcdefghijkmnopqrstuvwxyz023456789";
		srand((double)microtime()*1000000);
		$i = 1;
		$salt = '' ;

		while ($i <= $length)
		{
			$num = rand() % 33;
			$tmp = substr($chars, $num, 1);
			$salt .= $tmp;
			$i++;
		}
		return $salt;
	}

	/**
	 * @return string
	 */
	public static function getRandomPassword()
	{
		return self::getSalt(6);
	}

	public function beforeSave()
	{
		if (!in_array($this->getScenario(), array('newPassword')))
		{
			return TRUE;
		}
		$this->salt = self::getSalt();
		$this->password = self::hashPassword($this->password, $this->salt);
		return TRUE;
	}

	public static function getUserCookie()
	{
		if (isset($_COOKIE['user_secure']))
		{
			return $_COOKIE['user_secure'];
		}

		$secret = sha1($_SERVER['REMOTE_ADDR'].time());

		setcookie('user_secure', $secret, time() + 86400, '/');

		return $secret;
	}


}