<?php declare(strict_types=1);

require_once('layout.php');

use Lib\Controller\RoutesController;

$router = new RoutesController($view_template_setting);

/**
 * You can set your routes in this page
 *
 * addRoute method can accept one or two parameters
 * $router->addRoute($route, $filepath = null);
 * @param $route route config, the first parameter is required
 * @param $filepath view page name, the second parameter is optional
 * and assigned if route config's action name is different form view filename
 * 
 * Note*: If using controller class and action with $filepath declared,
 * make sure filepath is complete like 'Users/index' which points to
 * -> app/View/Users/index.php
 */
// $route['url'] is different from $filepath so second parameter is necessary
// points to app/View/home.php
$router->addRoute(['url' => '/', 'controller' => null, 'action' => null], 'home');

// $route['url'] is the same as $filepath so second parameter is unnecessary
// points to app/View/about.php
$router->addRoute(['url' => '/about', 'controller' => null, 'action' => null]);