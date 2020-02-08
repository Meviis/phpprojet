<?php
require_once 'config/init.conf.php';
require_once 'include/fonctions.inc.php';
require_once 'config/bdd.conf.php';
include_once 'include/header.inc.php';
/* @var $bdd PDO */


$tab_result = array // tableau vide
    ("titre" => "",
    "texte" => "",
    "date" => "",
    "publie" => "",);


if (!empty($_GET['action']) AND $_GET['action'] == 'modifier') {  //récupère les valeur de la table article
    $sth = $bdd->prepare("SELECT "
            . "titre, "
            . "texte, "
            . "DATE_FORMAT(date, '%d/%m/%Y') AS date_fr, "
            . "publie "
            . "FROM articles "
            . "WHERE id = :id");



//echo $date;
    /*
      /* @var $bdd PDD */
    /*
      $sth = $bdd->prepare("UPDATE articles SET "
      . "titre = :titre, "
      . "texte = :texte, "
      . "publie = :publie "
      . "WHERE id = :id ");
      $sth->bindValue("titre", $titre, PDO::PARAM_STR);
      $sth->bindValue("texte", $texte, PDO::PARAM_STR);
      $sth->bindValue("publie", $publie, PDO::PARAM_BOOL);
      $sth->bindValue("date", $date, PDO::PARAM_STR);

      $sth->execute();

      $id_articles = $bdd->lastInsertId();
     
    
    
    
    if (!empty($_POST['action']) and $_POST['action'] == "modifier") {
        $publier = isset($_POST['publier']) ? 1 : 0;
        $sth = $bdd->prepare("UPDATE Article "
                . "SET titre = :titre, texte = :texte, publie =:publie"
                . "WHERE id = :id");
        
        $sth->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
        $sth->bindValue(':texte',  $_POST['texte'], PDO::PARAM_STR);
        $sth->bindValue(':publie', $_POST['publie'], PDO::PARAM_BOOL);
        $sth->bindValue(':id',  $_POST['id'], PDO::PARAM_STR);
        $sth->execute();
    
        
*/
        
        
        
} else {
    if (!empty($_POST['submit'])) {
        print_r2($_POST);
        print_r2($_FILES);
        $titre = $_POST['titre'];
        $texte = $_POST['texte'];
        $publie = isset($_POST['publie']) ? 1 : 0;
        $date = date('Y-m-d');
//echo $date;

        /* @var $bdd PDD */
        $sth = $bdd->prepare("INSERT INTO articles " //prépare l'insertion de l'article dans la base de donné
                . "(titre, texte, publie, date) "
                . "VALUES (:titre, :texte, :publie, :date)");
        $sth->bindValue("titre", $titre, PDO::PARAM_STR);
        $sth->bindValue("texte", $texte, PDO::PARAM_STR);
        $sth->bindValue("publie", $publie, PDO::PARAM_BOOL);
        $sth->bindValue("date", $date, PDO::PARAM_STR);

        $sth->execute(); //execute la requete

        $id_articles = $bdd->lastInsertId(); //recupere et donne a la variable $id_articles le dernier id inseré dans la base de donné

        if ($_FILES['img']['error'] == 0) { //si l'image a le code 0 alors sa récupère l'image et le deplace dans le répertoire img
            move_uploaded_file($_FILES['img']['tmp_name'], 'img/' . $id_articles . '.jpg');

            $message = '<b>Félicitation<b>, votre <u> articles </u> est ajouté'; //affiche sur la page d'accueil lorsqu'un article s'est bien ajouté à la base de données
            $result = 'success'; //permet de savoir si la requête a été réalisée ou non

            declareNotification($message, $result);

            header("Location: index.php"); //redirige a la page d'accueil lorsque l'article a été inséré
            exit();  //permet de stopper le script
        }
    }
}
?>




<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center">
            <form method="post" action="article.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="titre">Le titre</label>
                    <input type="text" class="form-control" id="titre" placeholder="titre" name="titre"  value="<?php echo $tab_result["titre"]; ?>" >
                </div>
                <div class="form-group">
                    <label for="text">Contenue de l'article</label>
                    <textarea class="form-control" id="texte" rows="3" name="texte" " ><?php echo $tab_result["texte"]; ?></textarea>
                </div>  
                <div class="form-group">
                    <label for="img">l'image de mon article</label>
                    <input type="file" class="form-control-file" id="img" name="img" >
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="publie" name="publie" value="<?php if ($tab_result['publie'] == '1') { ?>checked<?php }; ?>>
                           <label class="form-check-label" for="publie">Publié</label>
                </div>
                <button type="submit" class="btn btn-primary" name="submit" value="ajouter">ajouter mon articles </button>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.slim.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>




