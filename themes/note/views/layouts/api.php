<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?=Yii::app()->name?> API response | <?=$this->pageTitle?></title>
</head>
<body>
<h1><?=Yii::app()->name?> API response</h1>
<?php if (!empty($successMessage)):?>
	<div style="background: yellowgreen; color: #fff; padding: 10px; margin: 10px 0;">
		<strong>success messsage</strong>: <?=$successMessage?>
	</div>
<?php endif; ?>
<?php if (!empty($failureMessage)):?>
	<div style="background: lightcoral; color: #fff; padding: 10px; margin: 10px 0;">
		<strong>failure messsage</strong>: <?=$failureMessage?>
	</div>
<?php endif; ?>


<div style="padding: 10px; background: #E5ECF9; border: 1px solid #ccc; margin: 10px 0;">
	<strong>body</strong>: <?php if (!empty($body)):?>
		<?=$body?>
	<?php else:?>
		Empty body
	<?php endif;?>
</div>
</body>
</html>