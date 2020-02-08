<?php
require_once 'config/init.conf.php';
require_once('libs/Smarty.class.php');

$smarty = new Smarty();

$smarty->setTemplateDir('templates/');
$smarty->setCompileDir('templates_c/');
/*
//$smarty->setConfigDir('/web/www.example.com/guestbook/configs/');
//$smarty->setCacheDir('/web/www.example.com/guestbook/cache/');
*/

$prenom = 'vianney';

$smarty->assign('prenom',$prenom);

//** un-comment the following line to show the debug console
//$smarty->debugging = true;

$smarty->display('smarty-test.tpl');

?>