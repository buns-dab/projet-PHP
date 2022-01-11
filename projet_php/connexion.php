<?php
    try
    { 
        $objPdo = new PDO ('mysql:host=localhost;port=3306;dbname=baggioko1u_projphp;charset=utf8' , 'root', "" );
        echo "connexion ok<br/>\n";
    }
    catch( Exception $exception ) 
    {
        die($exception->getMessage());
    }

    /*try 
    { 
        $objPdo = new PDO ('mysql:host=devbdd.iutmetz.univ-lorraine.fr;port=3306;dbname=baggioko1u_projphp;charset=utf8' , 'baggioko1u_appli', '32019084' );
        echo "connexion ok<br/>\n";
    }
    catch( Exception $exception ) 
    {
        die($exception->getMessage());
    }*/

?>