<?php
    session_start();
    if ( $_SESSION['id'] ==  null ) {

    } else {
    
        $pseudo = $_SESSION['pseudo'];
        $idredacteur = $_SESSION['id'];
    
    }
    if(isset($_POST['ajout'])){
        $errors=array();
       
        $titresujet = trim(htmlentities($_POST['titresujet']));
        $textesujet = trim(htmlentities($_POST['textesujet']));
        require_once('fonctions.php');
     
    
        if(empty($titresujet)){
            array_push($errors, "Entrez le titre sujet");
        } 
        
        if(empty($textesujet)){
            array_push($errors, "Entrez le texte du sujet");
        }  
    
        if(count($errors) == 0)
        {
            $sujetAJout=ajoutSujet($idredacteur,$titresujet,$textesujet);
            $success = "Votre sujet a été créé";
            
            unset($idredacteur);
            unset($titresujet);
            unset($textesujet);

        }
    }
  ?>

  <!DOCTYPE html>

  <html>
    <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="./style/creerSujet.css"  />
        <title>Création d'un sujet</title>
    </head>
    <body>
        <div class="barre">
            <a href="acceuil.php">Retour à la liste des sujets</a>
        </div>
        
        <h1>Création d'un nouveau sujet</h1>
        
        <form action="creerSujet.php" method="post">
            <p><label for="titresujet">Saisir le titre sujet</label><br/>
            <input type="text" name="titresujet" id="titresujet"/></p>
            <p><label for="textesujet">Saisir le contenu du sujet</label><br/>
            <textarea name="textesujet" id="textesujet"  cols="30" rows="8"></textarea></p>
            <button type="submit"name="ajout">Ajouter</button>
            </form>
           
        <div class="erreur">
        <?php
        if(isset($success))
            echo "<p style='color:red;'>".$success."</p>";

        if(!empty($errors)):?>

            <?php foreach($errors as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>

        <?php endif; ?>
        </div>
       
        
    </body>
</html>
    