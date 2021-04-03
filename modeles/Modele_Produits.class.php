<?php
    class Modele_Produits extends BaseDAO
    {
        public function getNomTable()
        {
            return "produits";
        }

        public function getClePrimaire()
        {
            return "id";
        }

        public function obtenir_par_id($id)
        {
            //on appelle obtenir_par_id du parent et on créé un objet Produit à partir de la rangée retournée
            $resultats = parent::obtenir_par_id($id);
            $resultats->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE , "Produit");
            $produit = $resultats->fetch();
            return $produit;
        }

        public function obtenir_tous($ordre = "", $limit = "")
        {
            //on appelle obtenir_par_id du parent et on fetch un tableau de Produits
            $resultats = parent::obtenir_tous("", "limit 12");
            $produits = $resultats->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Produit");
            return $produits;
        }

        public function obtenir_tousAJAX($ordre = "", $limit = "")
        {
            //on appelle obtenir_par_id du parent et on fetch un tableau de Produits
            $resultats = parent::obtenir_tous($ordre, $limit);
            $produits = $resultats->fetchAll(PDO::FETCH_ASSOC);
            return $produits;
        }

        public function sauvegarde(Produit $produit)
        {
            //est-ce que le produit que j'essaie de sauvegarder existe déjà (id différent de zéro)
            if($produit->getId() != 0)
            {
                //mise à jour -- UPDATE produits SET...
                $requete = "UPDATE produits SET nom=:n, prix=:p, lienimage=:l, inventaire=:i WHERE id=:id";
                $requetePreparee = $this->db->prepare($requete);
                $id = $produit->getId();
                $nom = $produit->getNom();
                $prix = $produit->getPrix();
                $lienimage = $produit->getLienImage();
                $inventaire = $produit->getInventaire();
                $requetePreparee->bindParam(":id", $id);
                $requetePreparee->bindParam(":n", $nom);
                $requetePreparee->bindParam(":p", $prix);
                $requetePreparee->bindParam(":l", $lienimage);
                $requetePreparee->bindParam(":i", $inventaire);
                $requetePreparee->execute();                
            }
            else
            {
                //ajout d'un nouveau produit
                $requete = "INSERT INTO produits(nom, prix, lienimage, inventaire) VALUES (:n,:p,:l,:i)";
                $requetePreparee = $this->db->prepare($requete);
                $nom = $produit->getNom();
                $prix = $produit->getPrix();
                $lienimage = $produit->getLienImage();
                $inventaire = $produit->getInventaire();
                $requetePreparee->bindParam(":n", $nom);
                $requetePreparee->bindParam(":p", $prix);
                $requetePreparee->bindParam(":l", $lienimage);
                $requetePreparee->bindParam(":i", $inventaire);
                $requetePreparee->execute();
            }
        }
    }

?>