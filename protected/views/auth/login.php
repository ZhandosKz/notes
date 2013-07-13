<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$form = $this->beginWidget('CActiveForm', array(
	'id'=>'login_form',
	'enableClientValidation'=>true,
	'enableAjaxValidation' => true,
	'htmlOptions'=>array('class'=>'well'),
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
<div class="form">
	<?=$form->labelEx($model, 'username');?>
	<?=$form->textField($model, 'username')?>
	<br/>
	<?=$form->labelEx($model, 'password')?>
	<?=$form->passwordField($model, 'password')?>
	<br/>
	<?=CHtml::submitButton('Войти')?>
</div>
<?php $this->endWidget();?>
