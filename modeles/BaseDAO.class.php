<?php
    abstract class BaseDAO
    {
        //objet PDO contenant une connexion à la base de données
        protected $db;

        public function __construct(PDO $connexion)
        {
            $this->db = $connexion;
        }

        //méthodes abstraites à être définies plus tard
        abstract function getNomTable();
        abstract function getClePrimaire();

        //lecture (READ)
        public function obtenir_par_id($id)
        {
            $requete = "SELECT * FROM " . $this->getNomTable() . " WHERE " . $this->getClePrimaire() . "=:id";
            $requetePreparee = $this->db->prepare($requete);
            $requetePreparee->bindParam(":id", $id);
            $requetePreparee->execute();

            //on retourne l'identifiant de la dernière insertion
            return $requetePreparee;
        }

        public function obtenir_tous($ordre = "", $limit = "")
        {
            $requete = "SELECT * FROM " . $this->getNomTable() . " $ordre $limit";
            $resultats = $this->db->query($requete);
            return $resultats;
        }

        //suppression (DELETE)
        public function supprime($id)
        {
            $requete = "DELETE FROM " . $this->getNomTable() . " WHERE " . $this->getClePrimaire() . "=:id";
            $requetePreparee = $this->db->prepare($requete);
            $requetePreparee->bindParam(":id", $id);
            $requetePreparee->execute();

            //on retourne le nombre de rangées affectées 
            return $requetePreparee->rowCount();
        }
    }

?>