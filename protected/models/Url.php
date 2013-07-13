<?php

/**
 * This is the model class for table "url".
 *
 * The followings are the available columns in table 'url':
 * @property integer $id
 * @property string $object_alias
 * @property integer $object_id
 * @property string $path
 */
class Url extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Url the static model class
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
		return 'url';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('object_id', 'numerical', 'integerOnly'=>true),
			array('object_alias, path', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, object_alias, object_id, path', 'safe', 'on'=>'search'),
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
			'object_alias' => 'Object Alias',
			'object_id' => 'Object',
			'path' => 'Path',
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
		$criteria->compare('object_alias',$this->object_alias,true);
		$criteria->compare('object_id',$this->object_id);
		$criteria->compare('path',$this->path,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function getRandom($length = 10)
	{
		$chars = 'abcdefghijkmnopqrstuvwxyz023456789ABCDEFGHIJKMNOPQRSTUVWXYZ';
		$command = Yii::app()->db->createCommand();
		do
		{
			$path = substr(str_shuffle($chars), 1, $length);
		}
		while($command->reset()->select('count(*)')->from(self::tableName())->where('path = :path', array(':path' => $path))->queryScalar());

		return $path;
	}


}