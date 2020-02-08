<?php
require_once 'config/init.conf.php';
require_once 'include/fonctions.inc.php';
require_once 'config/bdd.conf.php';
require_once('libs/Smarty.class.php');
include_once 'include/header.inc.php';

/* @var $bdd PDO */


if (isset($_POST['submit'])) {
    print_r2($_POST);
   // exit();
 

 

$email = $_POST['email'];
$mdp = sha1($_POST['mdp']); //fonction de hachage cryptographique 

$sth = $bdd->prepare("SELECT * "  //prépare les informations de l'utilisateur dans la base de donné
        . "FROM utilisateur "
        . "WHERE email = :email AND mdp = :mdp");
$sth->bindValue(':email', $email, PDO::PARAM_STR);
$sth->bindValue(':mdp', $mdp, PDO::PARAM_STR);



 

$sth->execute(); //execute la requete

      
if ($sth->rowCount() > 0) {
    // La connexion est ok
    $donnes = $sth->fetch(PDO::FETCH_ASSOC);
    //print_r2($donnes);
    $sid = $donnes['email'] . time();
    $sid_hache = md5($sid);
    //echo $sid_hache;

 
    setcookie('sid' , $sid_hache, time() + 3600);
  
    $sth_update = $bdd->prepare("UPDATE utilisateur "
            . "SET sid = :sid "
            . "WHERE id = :id");

   $sth_update->bindValue(':sid', $sid_hache, PDO::PARAM_STR);
   $sth_update->bindValue(':id', $donnes['id'], PDO::PARAM_INT);
  

   $result_connexion = $sth_update->execute();
   //var_dump($sth_update);


// Notifications

if ($result_connexion == TRUE){
    $_SESSION['notification']['result'] = 'success';
    $_SESSION['notification']['message'] = '<b>Félicitation</b>';

} else {
    $_SESSION['notification']['result'] = 'danger';
    $_SESSION['notification']['message'] = '<b> Attention!</b>';

}



//Redirection vers l'accueil

header("Location: index.php");

exit();

} else {
    //La connexion est refusée
    //notification
    $_SESSION['notification']['result'] = 'danger';
    $_SESSION['notification']['message'] = '<b> Attention!</b>';
header("Location: index.php");


exit();//fin de l'exécution du script

}}

//smarty Il facilite la séparation entre la logique applicative et la présentation

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

$smarty->display('connection.tpl');

unset($_SESSION['notification']);


?>


