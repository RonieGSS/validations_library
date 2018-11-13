<?php declare(strict_types=1);

namespace Lib\Controller;

/**
 * Responsible for view templates
 *
 */
class ViewController
{
	/**
	 * @var string $header
	 */
	private $header;

	/**
	 * @var string $footer
	 */
	private $footer;

	/**
	 * Sets header
	 *
	 * @param $header string template header
	 */
	public function setHeader(string $header = 'header.php')
	{
		$this->header = $header;
	}

	/**
	 * Sets footer
	 *
	 * @param $footer string template footer
	 */
	public function setFooter(string $footer = 'footer.php')
	{
		$this->footer = $footer;
	}

	/**
	 * Gets header
	 *
	 * @return $header string template header
	 */
	public function getHeader()
	{
		return $this->header;
	}

	/**
	 * Gets footer
	 *
	 * @return $footer string template footer
	 */
	public function getFooter()
	{
		return $this->footer;
	}
}