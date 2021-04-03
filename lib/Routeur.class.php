<?php
   class Routeur
   {
       public static function route()
       {
            //obtenir la query string (tout ce qui se trouve à droite du ? dans la requête)
            //ex: index.php?NomControleur&cmd=liste&params=test
            $queryString = $_SERVER["QUERY_STRING"];

            if($queryString != "")
            {
                $posEperluette = strpos($queryString, "&");
                if($posEperluette === false)
                {
                    //pas de paramètres (ex : index.php?Films)
                    $controleur = $queryString;
                }
                else
                {
                    //avec paramètres (ex : index.php?Films&cmd=valeur)
                    $controleur = substr($queryString, 0, $posEperluette);
                }

            }
            else
            {
                //définir le contrôleur par défaut ICI (à spécifier plus tard)
                $controleur = "Produits";
            }

            //on a déterminé le nom du contrôleur
            //chaque classe controleur s'appelle Controleur_NomControleur
            $classe = "Controleur_" . $controleur; 

            if(class_exists($classe))
            {
                //instanciation dynamique de classe
                $objControleur = new $classe; 

                if($objControleur instanceof BaseControleur)
                {
                    //traitement de la requête
                    $objControleur->traite($_REQUEST); 
                }
                else
                {
                    trigger_error("Controleur invalide.");
                }

            }
            else
                trigger_error("La classe $classe n'existe pas.");
            
       }
   } 

?>