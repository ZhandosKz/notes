<div id="noteformw">
	<div id="id_body_wrap">
		<?=Yii::t('app', 'Your link:')?> <input contenteditable="false" size="25" onclick="$(this).select()" value="<?=$this->createAbsoluteUrl('/note/default/view', array('path' => $path))?>">
	</div>
</div>
