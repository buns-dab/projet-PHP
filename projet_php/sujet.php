<?php

session_start();
if ( $_SESSION['id'] ==  null ) {


} else {
    $pseudo = $_SESSION['pseudo'];
    $prenom = $_SESSION['prenom'];
    $nom = $_SESSION['nom'];
    $idredacteur = $_SESSION['id'];

}
$_SESSION['url'] = ("sujet.php?idsujet=".$_GET['idsujet']);
if(!isset($_GET['idsujet']) OR !is_numeric($_GET['idsujet']))
    header("Location : acceuil.php");
else
{
    extract($_GET);
    $idsujet = strip_tags($idsujet); //retourne chaine sans balise php et html 

    require_once('fonctions.php');

    if(!empty($_POST['textereponse']))
    {
        extract($_POST);
        $errors = array();
        $textereponse = strip_tags($textereponse);
       
        if(empty($textereponse))
        {
            array_push($errors, "Entrez un commentaire");
        }

        if(count($errors) == 0)
        {
            $comment = ajoutComment($idsujet,$idredacteur, $textereponse);

            $success = "Votre commentaire a été publié";

            unset($textereponse); //met à zéro la variable texte réponse
            unset($idredacteur);
            header("location: ".$_SESSION['url']);
        }
    }

    $sujet = getSujet($idsujet);
    $reponse = getComments($idsujet);
}
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8" />
        <title><?= $sujet->titresujet ?></title>
    </head>

    <body>
        <a href="acceuil.php"> Retour aux sujets </a>
        <?php 
        if ( $_SESSION['id'] == NULL ) {
            echo '<a href=authentification.php> Se connecter</a>';
        } else {
            echo '<a href=creer.php> Modification </a>';
            echo'</br>';
            echo '<a href="deconnection.php">Se déconnecter</a>';
            echo'</br>';
        }?>
        <h1><?= $sujet->titresujet ?></h1>
        <time><?= $sujet->datesujet ?> </time>
        <p><?= $sujet->textesujet ?></p>
        <hr />

        <?php
        if(isset($success))
            echo $success;

        if(!empty($errors)):?>

            <?php foreach($errors as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>

        <?php endif; ?>

        <form action="sujet.php?idsujet=<?= $sujet->idsujet ?>" method="post">
            <p><label for="textereponse">Commentaire :</label><br/>
            <textarea name="textereponse" id="textereponse" cols="30" rows="8"></textarea></p>
            <button type="submit">Publier </button>
            </form>
            
        <h2>Commentaires : </h2>
        <?php foreach($reponse as $com): ?>
            <time><?= $com->daterep ?></time>
            <p><?= $com->idredacteur ?></p>
            <p><?= $com->textereponse ?></p>
        <?php endforeach; ?> 
    </body>
</html>