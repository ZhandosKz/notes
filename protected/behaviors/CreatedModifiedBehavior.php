<?php
class CreatedModifiedBehavior extends CActiveRecordBehavior
{
	public  function beforeSave($event)
	{
		if ($this->owner->isNewRecord && $this->owner->hasAttribute('created_at') && $this->owner->hasAttribute('created_by'))
		{
			$this->owner->created_at = date('Y-m-d H:i:s');
			$this->owner->created_by = Yii::app()->user->id;
		}
		elseif ($this->owner->hasAttribute('modified_at') && $this->owner->hasAttribute('modified_by'))
		{
			$this->owner->modified_at = date('Y-m-d H:i:s');
			$this->owner->modified_by = Yii::app()->user->id;
		}
	}
}