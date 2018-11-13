<?php declare(strict_types=1);

use Lib\Controller\ViewController;

$view_template_setting = new ViewController();

/**
 * The current header can be found at app/View/Common/header.php
 * You can set customized header
 * (ex. $view_template_setting->setHeader(myheader.php);)
 */
$view_template_setting->setHeader();

/**
 * The current footer can be found at app/View/Common/footer.php
 * You can set customized footer
 * (ex. $view_template_setting->setFooter(myfooter.php);)
 */
$view_template_setting->setFooter();


