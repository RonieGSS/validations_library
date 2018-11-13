<?php
	require('vendor/autoload.php');
	require_once('app/Config/routes.php');
	$router->requireRoute(htmlentities("/{$_GET['url']}"));
