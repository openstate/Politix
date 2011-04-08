<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'../includes/prequel.inc.php');
	require_once('{processorclass}{action}.class.php');

	$form = new {processorclass}{action}();
	$form->setPost{action}($_POST);
	if (!$form->validate()) {
		$form->saveToSession();
		header('Location: {displayfile}{ifedit}?id='.$_POST['{id}']{/ifedit});
		die;
	}
	$form->saveToObject();
	$form->clearSession();
?>