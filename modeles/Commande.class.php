<?php

    class Commande
    {
        private $id;
        private $detail;
        private $montant;

        public function __construct($id = 0, $d = "", $m = "")
        {
            $this->id = $id;
            $this->detail = $d;
            $this->montant = $m;
        }

        public function getId()
        {
            return $this->id;
        }

        public function getDetail()
        {
            return $this->detail;
        }

        public function getMontant()
        {
            return $this->montant;
        }
    }

?>