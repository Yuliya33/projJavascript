<?php

    class Usager
    {
        private $id;
        private $nom;
        private $prenom;
        private $adresse;
        private $codepostal;
        private $courriel;
        private $optin;

        public function __construct($id = 0, $n = "", $p = "", $a = "", $cp = "", $cou = "", $op = "")
        {
            $this->id = $id;
            $this->nom = $n;
            $this->prenom = $p;
            $this->adresse = $a;
            $this->codepostal = $cp;
            $this->courriel = $cou;
            $this->optin = $op;
        }

        public function getId()
        {
            return $this->id;
        }

        public function getNom()
        {
            return $this->nom;
        }

        public function getPrenom()
        {
            return $this->prenom;
        }

        public function getAdresse()
        {
            return $this->adresse;
        }

        public function getCodePostal()
        {
            return $this->codepostal;
        }

        public function getCourriel()
        {
            return $this->courriel;
        }

        public function getOptin()
        {
            return $this->optin;
        }
        
    }

?>