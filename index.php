<?php
require_once 'config/init.conf.php';
require_once 'include/fonctions.inc.php';
require_once 'config/bdd.conf.php';
require_once 'config/connection.conf.php';
require_once('libs/Smarty.class.php');



/* @var $bdd PDO */
//print_r2($_SESSION);

//print_r2($_GET);

$page_courante = !empty($_GET['p']) ? $_GET['p'] : 1;  //si p n'est pas vide il prend la valeur de ($_GET['p']) sinon il prend la valeur 1

$nb_total_articles = countArticles($bdd);
//var_dump($nb_total_articles);

$index_depart = returnIndex($page_courante, _nb_articles_par_page_);
//var_dump($index_depart);

$nb_total_pages = ($nb_total_articles / _nb_articles_par_page_);
//var_dump($nb_total_pages);

$sth = $bdd->prepare("SELECT id, " //prépare la requête
        . "titre, "
        . "texte, "
        . "DATE_FORMAT(date, '%d/%m/%Y') AS date_fr, "
        . "publie "
        . "FROM articles "
        . "WHERE publie = :publie "
        . "LIMIT :index_depart, :nb_articles_par_page ");


$sth->bindValue("publie", 1, PDO::PARAM_BOOL); //fonction pdo qui sécuriese le paramètre avant l'execution de la requete
$sth->bindValue("index_depart", $index_depart, PDO::PARAM_INT);
$sth->bindValue(":nb_articles_par_page", _nb_articles_par_page_, PDO::PARAM_INT);
$sth->execute(); //exécute la requête

$tab_result = $sth->fetchAll(PDO::FETCH_ASSOC); //retourne le tableau et récupère une ligne de résultat


//smarty Il facilite la séparation entre la logique applicative et la présentation

$smarty = new Smarty();

$smarty->setTemplateDir('templates/');
$smarty->setCompileDir('templates_c/');
/*
//$smarty->setConfigDir('/web/www.example.com/guestbook/configs/');
//$smarty->setCacheDir('/web/www.example.com/guestbook/cache/');
*/

$smarty->assign('tab_result', $tab_result);
$smarty->assign('nb_total_pages', $nb_total_pages);
$smarty->assign('page_courante', $page_courante);

//** un-comment the following line to show the debug console
//$smarty->debugging = true;

include_once 'include/header.inc.php';

$smarty->display('index.tpl');

unset($_SESSION['notification']);


?>


