<?php
    class Modele_Usagers extends BaseDAO
    {
        public function getNomTable()
        {
            return "usagers";
        }

        public function getClePrimaire()
        {
            return "id";
        }

        public function obtenir_par_id($id)
        {
            //on appelle obtenir_par_id du parent et on créé un objet Usager à partir de la rangée retournée
            $resultats = parent::obtenir_par_id($id);
            $resultats->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE , "Usager");
            $produit = $resultats->fetch();
            return $produit;
        }

        public function obtenir_par_courriel($courriel)
        {
            $requete = "SELECT * FROM " . $this->getNomTable() . " WHERE courriel=:courriel";
            $requetePreparee = $this->db->prepare($requete);
            $requetePreparee->bindParam(":courriel", $courriel);
            $requetePreparee->execute(); 

            // return $requetePreparee->debugDumpParams();
            $usager = $requetePreparee->fetch(PDO::FETCH_ASSOC);
            return $usager;
        }

        public function obtenir_tous($ordre = "", $limit = "")
        {
            //on appelle obtenir_par_id du parent et on fetch un tableau de Usager
            $resultats = parent::obtenir_tous();
            $produits = $resultats->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Usager");
            return $produits;
        }

        public function sauvegarde(Usager $usager)
        {
            //est-ce que le film que j'essaie de sauvegarder existe déjà (id différent de zéro)
            if($usager->getId() != 0)
            {
                //mise à jour -- UPDATE usager SET...
            }
            else
            {
                //ajout d'un nouveau usager
                $requete = "INSERT INTO usagers(nom, prenom, adresse, codepostal, courriel, optin) VALUES (:n,:p,:a,:cp,:cou,:op)";
                $requetePreparee = $this->db->prepare($requete);
                $nom = $usager->getNom();
                $prenom = $usager->getPrenom();
                $adresse = $usager->getAdresse();
                $codepostal = $usager->getCodePostal();
                $courriel = $usager->getCourriel();
                $optin = $usager->getOptin();

                $requetePreparee->bindParam(":n", $nom);
                $requetePreparee->bindParam(":p", $prenom);
                $requetePreparee->bindParam(":a", $adresse);
                $requetePreparee->bindParam(":cp", $codepostal);
                $requetePreparee->bindParam(":cou", $courriel); 
                $requetePreparee->bindParam(":op", $optin); 
                $requetePreparee->execute();
            }
        }
    }

?>