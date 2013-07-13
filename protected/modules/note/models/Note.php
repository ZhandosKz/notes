<?php

/**
 * This is the model class for table "note".
 *
 * The followings are the available columns in table 'note':
 * @property integer $id
 * @property string $text
 * @property string $reference
 * @property integer $user_id
 * @property integer $status
 */
class Note extends CActiveRecord
{
	const STATUS_OPEN = 0;
	const STATUS_CLOSED = 1;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Note the static model class
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
		return 'note';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status', 'numerical', 'integerOnly'=>true),
			array('reference', 'length', 'max'=>255),
			array('text', 'required', 'on' => 'create, update'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, text, reference, status', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'url' => array(self::HAS_ONE, 'Url', 'object_id', 'condition' => 'object_alias = :objectAlias', 'params' => array(':objectAlias' => 'Note'))
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'text' => 'Текст',
			'reference' => 'Сноски',
			'status' => 'Статус',
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
		$criteria->compare('text',$this->text,true);
		$criteria->compare('reference',$this->reference,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public function saveUrl()
	{
		if ($this->isNewRecord)
		{
			throw new CException('Сперва нужно создать заметку', E_USER_ERROR);
		}

		if (!$this->url instanceof Url)
		{
			$this->url = new Url();
			$this->url->object_alias = get_class($this);
			$this->url->object_id = $this->getPrimaryKey();
		}

		$this->url->path = Url::getRandom();

		if (!$this->url->save())
		{
			throw new CException('Ошибка сохранения ссылки', E_USER_ERROR);
		}
		return $this->url;
	}

	public function behaviors()
	{
		return array(
			'CreatedModified' => array(
				'class' => 'CreatedModifiedBehavior'
			),
		);
	}

}