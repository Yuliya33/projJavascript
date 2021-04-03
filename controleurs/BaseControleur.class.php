<?php
    abstract class BaseControleur
    {
        public abstract function traite(array $params);

        public function afficheVue($nomVue, $donnees = null)
        {
            $cheminVue = RACINE . "vues/" . $nomVue . ".php";
            
            if(file_exists($cheminVue))
            {
                //n.b. le paramètre $data sera utilisé DIRECTEMENT dans la vue
                include_once($cheminVue);
            }
            else
            {
                trigger_error("La vue spécifiée est introuvable.");
            }
        }

        public function obtenirDAO($nomModele)
        {
            $classe = "Modele_" . $nomModele;

            if(class_exists($classe))
            {
                //on créé la connexion à la BD (les constantes sont dans config.php)
                $connexionPDO = DBFactory::getDB(DBTYPE, DBNAME, HOST, USER, PWD);

                //on crée une instance de la classe Modele_$nomModele
                $objetModele = new $classe($connexionPDO);

                if($objetModele instanceof BaseDAO)
                {
                    return $objetModele;
                }
                else
                    trigger_error("Modèle invalide!");  
                
            }
            else
                trigger_error("La classe $classe n'existe pas.");
        }
    }

?>