<?php error_reporting(~E_NOTICE);

session_start();

if ( $_SESSION['id'] ==  null ) {

    $titre = "Création de compte";
    $mdptitre = "Mot de passe ( 8 caractères minimum ) : ";
    $mdptitre2 = "Confirmer votre mot de passe : ";
    $modif_user = $modif_email = $modif_prenom = $modif_nom = "";

} else {

    $titre = "Modification de compte";
    $mdptitre = "Nouveau mot de passe ( 8 caractères minimum ) : ";
    $mdptitre2 = "Confirmer votre ancient mot de passe : ";

    $modif_user = $_SESSION['pseudo'];
    $modif_email = $_SESSION['email'];
    $modif_pass = $_SESSION['pass'];
    $modif_prenom = $_SESSION['prenom'];
    $modif_nom = $_SESSION['nom'];
    
    $id = $_SESSION['id'];

}


if (isset($_POST['btn_submit'])) {
    $erreur = array();
    $valeur = array();
    $v_prenom = trim(htmlentities($_POST['prenom']));
    $v_nom = trim(htmlentities($_POST['nom']));
    $v_user = trim(htmlentities($_POST['pseudo']));
    $v_mail = trim(htmlentities($_POST['mail']));
    $v_pass = trim(htmlentities($_POST['pass']));
    $v_pass2 = trim(htmlentities($_POST['pass2']));

    require_once('connexion.php');
    $req_user = $objPdo->prepare("SELECT * FROM redacteur WHERE pseudo = \"$v_user\" ");
    $req_user->execute();
	
    if ( $_SESSION['id'] ==  null ) {
        if(!isset($v_nom) or strlen($v_nom)==0) {
            $erreur['nom'] = $erreur['nom']." | saisie obligatoire du nom";
        }  else if ( is_numeric($v_nom ) ) {
            $erreur['nom'] = $erreur['nom']." | nom doit être composé uniquement de lettres";
        }
    }
	
    if(!isset($v_prenom) or strlen($v_prenom)==0) {
        $erreur['prenom'] = $erreur['prenom']." | saisie obligatoire du prenom";
    }  else if ( is_numeric($v_prenom ) ) {
	$erreur['prenom'] = $erreur['prenom']." | nom doit être composé uniquement de lettres";
    }

    if(!isset($v_user) or strlen($v_user)==0) {
        $erreur['user'] = $erreur['user']." | saisie obligatoire du nom d\'utilisateur";
    } else if ( $req_user->rowCount() > 0 ) {
        $erreur['user'] = $erreur['user']." | pseudo déjà existant";  
    } else if ( strpos($v_user, '@') || strpos($v_user, '.')) {
        $erreur['user'] = $erreur['user']." | pseudo comporte au moins charactere illegal";
    }

    if(!isset($v_mail) or strlen($v_mail)==0) {
        $erreur['mail'] = $erreur['mail']." | saisie obligatoire du nom d\'une adresse email";
    } else if (!(filter_var($v_mail, FILTER_VALIDATE_EMAIL))) {
        $erreur['mail'] = $erreur['mail']." | adresse email invalide";
    }

    if(!isset($v_pass) or strlen($v_pass) < 8) {
        $erreur['pass'] = $erreur['pass']." | saisie obligatoire du mot de passe valide";
    }

    if(!isset($v_pass2) or strlen($v_pass2) < 8) {
        $erreur['pass2'] = $erreur['pass2']." | saisie obligatoire du mot de passe de confirmation valide";
    } else if ( $_SESSION['id'] ==  null ) {
    	if ( $v_pass !== $v_pass2 ) {
            $erreur['pass2'] = $erreur['pass2']." | mot de passe de confirmation incorrect";
        }
    } else {
    	if ( $v_pass2 !== $modif_pass ) {
    	    $erreur['pass2'] = $erreur['pass2']." | mot de passe ancient incorrect";
    	}
    }

    if (count($erreur)==0) {
        require_once('connexion.php');
		if ( $_SESSION['id'] ==  null ) {

            echo("marche");
			
            $req= $objPdo->prepare("INSERT INTO redacteur (nom,prenom,adressemail,motdepasse,pseudo)  VALUES( ? , ? , ? , ? , ? ) "); 
			$req->bindValue(1, $v_nom, PDO::PARAM_STR); 
			$req->bindValue(2, $v_prenom, PDO::PARAM_STR);
			$req->bindValue(3, $v_mail, PDO::PARAM_STR); 
			$req->bindValue(4, $v_pass, PDO::PARAM_STR);
			$req->bindValue(5, $v_user, PDO::PARAM_STR);			
			$req->execute();
		} else {
			
			$req= $objPdo->prepare("UPDATE redacteur SET prenom=?, adressemail=?, motdepasse=?, pseudo=? WHERE idredacteur = \"$id\" "); 
			$req->bindValue(2, $v_prenom, PDO::PARAM_STR);
			$req->bindValue(3, $v_mail, PDO::PARAM_STR); 
			$req->bindValue(4, $v_pass, PDO::PARAM_STR);
			$req->bindValue(5, $v_user, PDO::PARAM_STR);			
			$req->execute();
        }
        
        header("location: acceuil.php");
    }

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

<h2> <?php echo($titre) ?> </h2>

<form name="modif" action="" method="post">

<?php 

if ( $_SESSION['id'] ==  null ) {
	
	echo '<div>';
	echo '<label for="user">';
	echo 'Nom :' ;
	echo '</label>';
	echo '<br>';
	echo '<input type="text" id="nom" name="nom" />';
	echo '</div>';
}

?>

<div>
    <label for="user"> Prenom : </label>
    <br>
    <input type="text" id="prenom" name="prenom" value= '<?php echo($modif_prenom) ?>'/>

</div>

<div>
    <label for="user"> Pseudo : </label>
    <br>
    <input type="text" id="pseudo" name="pseudo" value= '<?php echo($modif_user) ?>'/>

</div>

<div>
    <label for="user"> Adresse email : </label>
    <br>
    <input type="text" id="mail" name="mail" value= '<?php echo($modif_email) ?>' />

</div>

<div>
    <label for="pass"> <?php echo($mdptitre) ?> </label>
    <br>
    <input type="password" id="pass" name="pass" />

</div>

<div>
    <label for="pass2"> <?php echo($mdptitre2) ?> </label>
    <br>
    <input type="password" id="pass2" name="pass2" />

</div>

    <input type="submit" name="btn_submit" value="Confirmer" />
    <input type="submit" name="btn_retour" value="Retour" />

</form>
</body>
</html>
