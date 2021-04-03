<?php
//définition de la racine du projet
define("RACINE", $_SERVER["DOCUMENT_ROOT"] . "/vaissellerie_artisanale/"); 
//définition des constantes de connexion à la BD
define("DBTYPE", "mysql");  
define("HOST", "localhost");
define("DBNAME", "boutique");
define("USER", "root");
define("PWD", "");
//définition de la fonction d'autoload
function mon_autoloader($classe)
{
    //liste des répertoires à fouiller pour trouver les classes 
    //si vous en ajoutez, ajoutez le ici aussi
    $repertoires = array(
        RACINE . "controleurs/",
        RACINE . "modeles/",
        RACINE . "lib/",
        RACINE . "vues/"
    );

    foreach($repertoires as $rep)
    {
        if(file_exists($rep . $classe . ".class.php"))
        {
            require_once($rep . $classe . ".class.php");
            return;
        }
    }
}

//enregistrer cette fonction comme étant notre autoloader
spl_autoload_register("mon_autoloader"); 

?>