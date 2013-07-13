<?php

class ModuleController extends CController
{

	protected $body;
	protected $successMessage;
	protected $failureMessage;
	protected $status = 200;

	protected $outputFormat = 'json';

	static private $_availableFormats = array(
		'json', 'html'
	);

	public function afterAction($action)
	{

		header('HTTP/1.1 '.$this->status.' '.RequestStatus::getStatusCodeMessage($this->status));

		$as = strtolower(MyArray::get($_GET, 'as'));

		if (in_array($as, self::$_availableFormats))
		{
			$this->outputFormat = $as;
		}

		switch ($this->outputFormat)
		{
			case 'json':
				header('Content-type: application/json');
				echo CJSON::encode(array(
					'status' => $this->status,
					'body' => $this->body,
					'successMessage' => $this->successMessage,
					'failureMessage' => $this->failureMessage,
				));
				break;
			case 'html':
				$this->renderPartial('//layouts/api', array(
					'status' => $this->status,
					'body' => json_encode($this->body),
					'successMessage' => $this->successMessage,
					'failureMessage' => $this->failureMessage,
				));
				break;
		}
		Yii::app()->end();
	}
}