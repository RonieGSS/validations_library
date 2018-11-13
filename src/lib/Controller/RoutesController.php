<?php declare(strict_types=1);

namespace Lib\Controller;

/**
 * Responsible for routing
 *
 */
class RoutesController
{
	/**
	 * @var route array, list of added routes
	 */
	private $route = [];

	/**
	 * @var controllers array, holds all Controller classes
	 */
	private $controllers = [];

	/**
	 * @var actions array, holds all functions 
	 * of each Controller classes
	 */
	private $actions = [];

	/**
	 * @var controller_dir string, directory of controller classes
	 */
	private $controller_dir = 'app/Controller/';

	/**
	 * @var template_dir string, directory of view templates
	 */
	private $template_dir = 'app/View/Common';

	/**
	 * @var Lib\Controller\ViewController object
	 */
	private $view_template_setting;

	public function __construct(ViewController $view_template_setting)
	{
		$this->view_template_setting = $view_template_setting;
		$this->setCreatedControllers();
	}

	/**
	 * Sets all created Controller classes
	 * in app/Controller directory to controllers array
	 *
	 * @param null
	 * @return null
	 */
	private function setCreatedControllers()
	{
		try {
			if (is_dir($this->controller_dir)) {
				if ($dir = opendir($this->controller_dir)) {
					while(($file = readdir($dir)) !== false) {
						if (!preg_match('/^\.+/',$file)) {
							$controller = strtolower(str_replace('Controller.php','',$file));
							$this->setCreatedActions($controller);
							$this->controllers[] = $controller;
						} // end of innermost if statement
					} // end of while loop
				} // end of inner if statement
			} // end of outermost if statement
		} catch (Exception $e) {
			echo '<h3>Oh man got this error -> </h3>' . $e->getMessage();
		}
	}

	/**
	 * Sets all created Controller classes' functions
	 * in app/Controller directory to actions array
	 * with controller name as key
	 *
	 * @param $controller string, lowercased name of controller
	 * @return null
	 */
	private function setCreatedActions(string $controller)
	{
		try {
			$file_to_open = $this->controller_dir . ucfirst($controller) . 'Controller.php';
			$file_to_read = fopen($file_to_open, "r") or die('Unable to open file');
			$read_file = htmlentities(fread($file_to_read, filesize($file_to_open)));
			preg_match_all('/public function .+(?='. preg_quote('(').')/', $read_file, $matches);
			foreach ($matches[0] as $match) {
				$action = trim(str_replace('public function ', '', $match));
				if ($action != '__construct') {
					$this->actions[$controller][] = $action;
					$this->setPrimaryRoutes($controller, $action);
				}
			} // end of inner foreach lopp
			fclose($file_to_read);
		} catch (Exception $e) {
			echo '<h3>Oh man got this error -> </h3>' . $e->getMessage();
		}
	}

	/**
	 * Set routes based from created controller classes
	 *
	 * @param $controller string the controller class to use
	 * @param $action string public function of the controller
	 */
	private function setPrimaryRoutes(string $controller, string $action)
	{
		$url = ($action != 'index') ? "/{$controller}/{$action}":"/{$controller}";
		$view = '/'.ucfirst($controller)."/{$action}";
		$this->route[$url] = $view;
	}

	/**
	 * Add routes
	 *
	 * @param $route array the route config to add
	 * @param $filepath string the mandatory file path to find
	 */
	public function addRoute(array $route, string $filepath = null)
	{
		try {
			$url = $route['url'];
			if (!$route['controller']) {
				$this->route[$url] = (preg_match('/\/$/', $url)) ? 
								 	  $url.$filepath : ($filepath) ? 
								 	  "/{$filepath}" : $url;
			} else if ($route['controller'] && $route['action']) {
				$this->route[$url] = ($filepath) ? "/{$route['controller']}/{$filepath}"
									 			 : "/{$route['controller']}/{$route['action']}";
			} else {
				require_once("{$this->template_dir}/{$this->view_template_setting->getHeader()}");
				echo '<h3 class="text-center">Route URL, Controller and Action are required!</h3>
					<h4 class="text-center">Check app/Config/routes.php file</h4>';
				require_once("{$this->template_dir}/{$this->view_template_setting->getFooter()}");
				die();
			}
		} catch (Exception $e) {
			echo '<h3>Oh man got this error -> </h3>' . $e->getMessage();
		}
	}

	/**
	 * Gets the view page requested by the route url
	 *
	 * @param $url string the requested route url
	 */
	public function requireRoute(string $url)
	{
		try {
			require_once("{$this->template_dir}/{$this->view_template_setting->getHeader()}");
			if (preg_match('/\/$/', $url) && strlen($url) > 1) {
				$url = rtrim($url, "/");
			}
			if (isset($this->route[$url])) {
				$view_file = 'app/View' . $this->route[$url] . '.php';
				if (file_exists($view_file)) {
					require_once($view_file);
				} else {
					echo '<h3 class="text-center">File '. $view_file . 
					' does not exist man. Create one if you like!</h3>';
				}
			} else {
				echo '<div class="col-md-4 offset-md-4 text-center">'.
					  '<h2>WAZZAP MAN!!!</h2>'.
					  '<h4>URL '.$url.' is invalid</h4>'.
					  '<h2>404 PAGE NOT FOUND YOW</h2>'.
					 '<h4>Check app/Config/routes.php file</h4></div>';
			}
			require_once("{$this->template_dir}/{$this->view_template_setting->getFooter()}");
		} catch (Exception $e) {
			echo '<h3>Oh man got this error -> </h3>' . $e->getMessage();
		}
	}
}