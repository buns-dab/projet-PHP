<?php 
require_once('fonctions.php');

session_start();

if ( $_SESSION['id'] ==  null ) {

} else {

    $pseudo = $_SESSION['pseudo'];
    $email = $_SESSION['email'];
    $mdp = $_SESSION['pass'];
    $prenom = $_SESSION['prenom'];
    $nom = $_SESSION['nom'];
    $_SESSION['url']="acceuil.php";
    $id = $_SESSION['id'];

}

$sujets = getSujets();
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8" />
        <title> Mon blog </title>
        <?php 
        if ( $_SESSION['id'] == NULL ) {
            echo '<a href=authentification.php> Se connecter</a>';
        } else {
            echo '<a href=creer.php> Modification </a>';
            echo'</br>';
            echo '<a href="deconnection.php">Se déconnecter</a>';
            echo'</br>';
            echo'<a href="creerSujet.php"> Créer un article </a>';
        }?>
    </head>

    <body>
        <h1> Sujets : </h1>

        <?php foreach($sujets as $sujet): ?>
            <h2><?= $sujet->titresujet ?> </h2>
            <time><?= $sujet->datesujet ?> </time>
            <br/> 
            <a href="sujet.php?idsujet=<?= $sujet->idsujet ?>">Lire la suite</a>
            <?php endforeach; ?>
    </body>

</html>