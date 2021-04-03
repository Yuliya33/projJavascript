<?php
    class Modele_Commandes extends BaseDAO
    {
        public function getNomTable()
        {
            return "commandes";
        }

        public function getClePrimaire()
        {
            return "id";
        }

        public function obtenir_par_id($id)
        {
            //on appelle obtenir_par_id du parent et on créé un objet Commande à partir de la rangée retournée
            $resultats = parent::obtenir_par_id($id);
            $resultats->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE , "Commande");
            $produit = $resultats->fetch();
            return $produit;
        }

        public function obtenir_tous($ordre = "", $limit = "")
        {
            //on appelle obtenir_par_id du parent et on fetch un tableau de Commande
            $resultats = parent::obtenir_tous();
            $produits = $resultats->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Commande");
            return $produits;
        }

        public function sauvegarde(Commande $commande)
        {
            //est-ce que le film que j'essaie de sauvegarder existe déjà (id différent de zéro)
            if($commande->getId() != 0)
            {
                //mise à jour -- UPDATE commande SET...
            }
            else
            {
                //ajout d'un nouveau commande
                $requete = "INSERT INTO commandes(detail, montant) VALUES (:d,:m)";
                $requetePreparee = $this->db->prepare($requete);
                $detail = $commande->getDetail();
                $montant = $commande->getMontant();

                $requetePreparee->bindParam(":d", $detail);
                $requetePreparee->bindParam(":m", $montant);
                $requetePreparee->execute();
            }
        }
    }

?>