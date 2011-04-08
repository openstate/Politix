<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'../includes/prequel.inc.php');
	require_once('CustomSmarty.class.php');
	require_once('{processorclass}.class.php');

	$smarty = new CustomSmarty('en');

	$form = new {processorclass}();
	if (isset($_POST)) {
		$form->processPost($_POST);
	}

	$form->preDisplay();
	echo $form->getHTML($smarty);
?>