<?php

    class Produit
    {
        private $id;
        private $nom;
        private $prix;
        private $lienimage;
        private $inventaire;

        public function __construct($id = 0, $n = "", $p = "", $li = "", $in = "")
        {
            $this->id = $id;
            $this->nom = $n;
            $this->prix = $p;
            $this->lienimage = $li;
            $this->inventaire = $in;
        }

        public function getId()
        {
            return $this->id;
        }

        public function getNom()
        {
            return $this->nom;
        }

        public function getPrix()
        {
            return $this->prix;
        }

        public function getLienImage()
        {
            return $this->lienimage;
        }

        public function getInventaire()
        {
            return $this->inventaire;
        }

        public function setInventaire($inventaire)
        {
            $this->inventaire = $inventaire;
        }
    }

?>