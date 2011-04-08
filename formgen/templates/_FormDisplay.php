<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'../includes/prequel.inc.php');
	require_once('CustomSmarty.class.php');
	require_once('{processorclass}{action}.class.php');

	$smarty = new CustomSmarty('en');

	$form = new {processorclass}{action}();
	$loaded = $form->loadFromSession();
	{ifedit}if (!$loaded) $form->loadFromObject($_GET['id']);{/ifedit}
	$form->assignData($smarty);

	$smarty->display('{htmltemplate}');

?>