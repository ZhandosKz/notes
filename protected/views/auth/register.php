<?php
/**
 * @var CActiveForm $form
 * @var RegistrationForm $model
 */
$form = $this->beginWidget('CActiveForm', array(
	'id'=>'registration_form',
	'enableAjaxValidation' => true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
<div class="form">
	<?=$form->labelEx($model, 'username')?>
	<?=$form->textField($model, 'username')?>
	<br/>
	<?=$form->labelEx($model, 'password')?>
	<?=$form->passwordField($model, 'password')?>
	<br/>
	<?=$form->labelEx($model, 'passwordConfirm')?>
	<?=$form->passwordField($model, 'passwordConfirm')?>
	<br/>
	<label><?=$form->checkBox($model, 'acceptRules').$model->getAttributeLabel('acceptRules')?></label>
	<br/>
	<?=CHtml::submitButton('Регистрация')?>
</div>
<?php $this->endWidget();?>