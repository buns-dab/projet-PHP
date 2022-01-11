<?php 

session_start();
 
$_SESSION['url'] ='authentification.php';  

if (isset($_POST['btn_login'])) {
    $erreur = array();
    $valeur = array();
    $v_user = trim(htmlentities($_POST['user']));
    $v_pass = trim(htmlentities($_POST['pass']));

    if(!isset($v_user) or strlen($v_user)==0) {
        $erreur['user'] = 'saisie obligatoire du nom d\'utilisateur ou de l\'adresse email';
    }

    if(!isset($v_pass) or strlen($v_pass) < 8) {
        $erreur['pass'] = 'saisie obligatoire du mot de passe';
    }

    if (count($erreur)==0) {
        require_once('connexion.php');
        if (strpos($v_user, '@')) {
            $req = $objPdo->prepare("SELECT * FROM redacteur WHERE adressemail = \"$v_user\" AND motdepasse = \"$v_pass\" ");
            $req->execute();
        } else {
            $req = $objPdo->prepare("SELECT * FROM redacteur WHERE pseudo = \"$v_user\" AND motdepasse = \"$v_pass\" ");
            $req->execute();
        }

        if ( $req->rowCount() == 0 ) {
            echo("Identification échouée, erreur.");
       } else {
           while ($row=$req->fetch()) {

               $_SESSION['id'] = $row['idredacteur'];
               $_SESSION['nom'] = $row['nom'];
               $_SESSION['prenom'] = $row['prenom'];
               $_SESSION['pseudo'] = $row['pseudo'];
               $_SESSION['email'] = $row['adressemail'];
               $_SESSION['pass'] = $row['motdepasse'];
               header("location: acceuil.php");

           }
        }
    }

}

if (isset($_POST['btn_creer'])) {
    header("location: creer.php");
}

if (isset($_POST['btn_retour'])) {
    header("location: acceuil.php");
}

?>

<html>
<head>
    <meta charset="utf-8">
    <title>Articles</title>
</head>

<body>

<h2> Authentification </h2>

<form name="login" action="" method="post">

<div>
    <label for="user"> Pseudo ou email : </label>
    <br>
    <input type="text" id="user" name="user"/>

</div>

<div>
    <label for="pass"> Mot de passe ( 8 caractères minimum ) : </label>
    <br>
    <input type="password" id="pass" name="pass" />

</div>

    <input type="submit" name="btn_login" value="Connexion" />
    <input type="submit" name="btn_creer" value="Créer un nouveau compte" />
    <br>
    <input type="submit" name="btn_retour" value="Retour vers la page principale" />

</form>
</body>
</html>
