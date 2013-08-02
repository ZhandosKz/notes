<h3>
	Copy this link and paste it into an email or instant message and send it to whom you want to read the note, or
	<?=CHtml::link('destroy it now', $this->createAbsoluteUrl('/note/default/view', array('path' => $path)), array('id' => 'destroylink'))?>
</h3>
<input id="notelink" type="text" onclick="$(this).select()" readonly="readonly" size="50" value="<?=$this->createAbsoluteUrl('/note/default/view', array('path' => $path))?>">
<h3 id="create">
	<a href="/">Create another note</a>
</h3>