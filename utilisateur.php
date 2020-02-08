<?php
require_once 'config/init.conf.php';
require_once 'include/fonctions.inc.php';
require_once 'config/bdd.conf.php';
require_once('libs/Smarty.class.php');
include_once 'include/header.inc.php';
/* @var $bdd PDO */




if(!empty($_POST['submit'])){
print_r2($_POST);



$email = $_POST['email'];
$mdp = sha1($_POST['mdp']);
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];



$sth = $bdd->prepare("INSERT INTO utilisateur "
        ."(email, mdp, nom, prenom) "
        ."VALUES (:email, :mdp, :nom, :prenom)");
$sth->bindValue("email",$email, PDO::PARAM_STR );
$sth->bindValue("mdp",$mdp, PDO::PARAM_STR );
$sth->bindValue("nom",$nom, PDO::PARAM_STR);
$sth->bindValue("prenom",$prenom, PDO::PARAM_STR );

$sth->execute();

$id_utilisateur = $bdd->lastInsertId();

header("Location: index.php");
exit();

}


//smarty

$smarty = new Smarty();

$smarty->setTemplateDir('templates/');
$smarty->setCompileDir('templates_c/');
/*
//$smarty->setConfigDir('/web/www.example.com/guestbook/configs/');
//$smarty->setCacheDir('/web/www.example.com/guestbook/cache/');
*/

//$smarty->assign('tab_result', $tab_result);


//** un-comment the following line to show the debug console
//$smarty->debugging = true;

include_once 'include/header.inc.php';

$smarty->display('utilisateur.tpl');

unset($_SESSION['notification']);




?>

