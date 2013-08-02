<?php
/**
 * @var $form CActiveForm
 * @var Note $model
 */
?>
<link rel="stylesheet" href="/libs/aloha/css/aloha.css" type="text/css">
<script src="/libs/aloha/lib/require.js"></script>
<script src="/libs/aloha/lib/aloha.js"
        data-aloha-plugins="common/ui,common/format,common/highlighteditables,common/link"></script>
<script>
	Aloha.ready( function() {
		Aloha.jQuery('#id_body').aloha();
	});
</script>
<div id="noteformw">
	<h3>Write your note below</h3>
	<?php $form = $this->beginWidget('CActiveForm'); ?>
		<div id="body_errors">
			<?=$form->errorSummary($model)?>
		</div>
		<div id="id_body_wrap">
			<?=$form->textArea($model, 'text', array('id' => 'id_body'))?>
		</div>

		<p id="notifycheck" class="notify">
			<input id="id_notify" type="checkbox" class="checkbox" name="notify"/>
			<label for="id_notify">Notify me when this note gets read</label>
		</p>
		<div id="notify" class="notify">
			<div id="email_errors"></div>
			<div class="left">
				<p><label for="id_sender_email">Your e-mail</label>:
					<input id="id_sender_email" type="text" name="sender_email" size="30" maxlength="100"/></p>
			</div>
			<div class="right">
				<p><label for="id_reference">Note reference</label>:
					<input id="id_reference" type="text" name="reference" size="10" maxlength="50"/></p>
			</div>
		</div>
		<p id="pwrapper">
			<?=CHtml::htmlButton('<span class="button"><span>Create note</span></span>', array('id' => 'button', 'type' => 'submit'))?>
		</p>
		<p id="agreement">Please read our <a href="/privacy/">Privacy Policy</a> before clicking on the "Create note" button.</p>
	<?php $this->endWidget();?>
</div>