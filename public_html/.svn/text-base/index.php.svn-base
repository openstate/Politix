<?php
	try {
		require_once('../includes/prequel.include.php');
		require_once('Dispatcher.class.php');

		$se = &$_SESSION['search'];
		if (null != $se && CACHE_LIFETIME < (time() - $se['time'])) $se = null;

		$dispatcher = new Dispatcher();
		$dispatcher->dispatch();
	} catch (Exception $e) {
		echo '<pre>'.$e->__toString().'</pre>';
	}

	//var_dump(array_keys($_SESSION));
	//var_dump($_SESSION['user']);
	//$sites = $_SESSION['user']->listSites();
	//foreach ($sites as $site) {
//		echo $site->title, "<br>\n";
//	}
?>