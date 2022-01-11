<?php 
//fonction qui recupère tous les sujets
function getSujets()
{
    require('connexion.php');
    $req = $objPdo->prepare('SELECT idsujet, titresujet,datesujet FROM sujet ORDER BY idsujet DESC');
    $req->execute();
    $data = $req->fetchAll(PDO::FETCH_OBJ);
    return $data;
  
}

//fonction qui récupère un sujet
function getSujet($idsujet)
{
    require('connexion.php');
    $req = $objPdo->prepare('SELECT * FROM sujet WHERE idsujet = ?');
    $req->execute(array($idsujet));
    if($req->rowCount()== 1)
    {
        $data = $req->fetch(PDO::FETCH_OBJ);
        return $data;
    }
    else
        header('Location: acceuil.php');
   
}
//fonction qui ajoute un commentaire 
function ajoutComment($idsujet,$idredacteur,$textereponse)
{
    require('connexion.php');
    $req = $objPdo->prepare('INSERT INTO reponse(idsujet,idredacteur,daterep,textereponse) VALUES(?,?,NOW(),?)');
    $req->execute(array($idsujet,$idredacteur,$textereponse));

}

//fonction qui récupère les commentaires d'un sujet
function getComments($idsujet)
{
    require('connexion.php');
    $req= $objPdo->prepare('SELECT * FROM reponse WHERE idsujet = ?');
    $req->execute(array($idsujet));
    $data = $req->fetchAll(PDO::FETCH_OBJ);
    return $data;
}
function ajoutSujet($idredacteur,$titresujet,$textesujet)
{
    require('connexion.php');
    $req = $objPdo->prepare('INSERT INTO sujet(idredacteur,titresujet,textesujet,datesujet) VALUES(?,?,?,NOW())');
    $req->execute(array($idredacteur,$titresujet,$textesujet));
}
?>