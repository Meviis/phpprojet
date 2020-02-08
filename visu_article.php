<?php
require_once 'config/init.conf.php';
require_once 'include/fonctions.inc.php';
require_once 'config/bdd.conf.php';
require_once 'config/connection.conf.php';
require_once('libs/Smarty.class.php');

/*
$bdd = new PDO('mysql:host=localhost;dbname=commentaire;charset=utf8', 'root', '');
*/

$sth = $bdd->prepare("SELECT id, "
        . "titre, "
        . "texte "
        . "FROM articles "
        . "WHERE id = :id "
        . "LIMIT 1");

$sth->bindValue("id", $_GET['id'], PDO::PARAM_BOOL);
$sth->execute();

$tab_result = $sth->fetch(PDO::FETCH_ASSOC);


/*
if(isset($_POST['submit_commentaire'])) {
      if(isset($_POST['commentairee']) AND !empty($_POST['commentairee'])) {
         $commentaire = htmlspecialchars($_POST['commentairee']);
         if(strlen($pseudo) < 25) {
            $ins = $bdd->prepare('INSERT INTO commentaires (pseudo, commentaire) VALUES (?,?,?)');
            $ins->execute(array($pseudo,$commentaire));
            $c_msg = "<span style='color:green'>Votre commentaire a bien été posté</span>";
         } else {
            $c_msg = "Erreur: Le pseudo doit faire moins de 25 caractères";
         }
      } else {
         $c_msg = "Erreur: Tous les champs doivent être complétés";
      }
   }
   $commentaires = $bdd->prepare('SELECT * FROM commentaires ORDER BY id DESC');
   $commentaires->execute(array());

*/



$smarty = new Smarty();

$smarty->setTemplateDir('templates/');
$smarty->setCompileDir('templates_c/');

$smarty->assign('tab_result', $tab_result);
/*
$smarty->assign('submit_commentaire', $submit_commentaire);
*/
include_once 'include/header.inc.php';

$smarty->display('visu_article.tpl');
