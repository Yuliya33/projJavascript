<?php

    class Controleur_Produits extends BaseControleur
    {
        public function traite(array $params)
        {
            $donnees = array();
            $vue = "";

           
            if(isset($params["cmd"]))
            {
                 $commande = $params["cmd"]; 
            }
            else
            {
                 //commande par défaut
                $commande = "accueil";
            }

        
            //détermine la vue, remplir le modèle approprié
            switch($commande)
            {
                case "accueil":
                    //afficher la page d'accueil
                    $this->afficheVue("Entete");

                    $modele = $this->obtenirDAO("Produits");
                    $data["produits"] = $modele->obtenir_tous(); 

                    $this->afficheVue("Accueil", $data);
                    $this->afficheVue("PiedDePage");               
                    break;
                case "panier":
                        //afficher la page de panier
                        $this->afficheVue("Entete");    
                        $this->afficheVue("Panier");
                        $this->afficheVue("PiedDePage");               
                    break;                    
                case "obtenirProduitsAJAX":

                    if(isset($_GET["numeroCourant"], $_GET["nombreProduits"]))
                    {
                        $modele = $this->obtenirDAO("Produits");
                        $numeroCourant = $_GET["numeroCourant"];
                        $nombreProduits = $_GET["nombreProduits"];
                        $ordre = $_GET["ordre"] != "" ? "order by ".$_GET["ordre"]:"";
                        echo json_encode($modele->obtenir_tousAJAX($ordre,"limit $numeroCourant,$nombreProduits"));
                    }

                    break;
                case "verifierCourrielAJAX":

                        if(isset($_GET["courriel"]))
                        {
                            $modele = $this->obtenirDAO("Usagers");
                            $usager = $modele->obtenir_par_courriel($_GET["courriel"]);
                            echo json_encode($modele->obtenir_par_courriel($_GET["courriel"]));
                        }
    
                    break;

                case "ajouterUsagerAJAX":

                        if(isset($params["nom"],$params["prenom"],$params["adresse"],$params["codepostal"],$params["courriel"],$params["optin"]))
                        {
                            $modele = $this->obtenirDAO("Usagers");
                            $nUsager = new Usager(0, $params["nom"],$params["prenom"],$params["adresse"],$params["codepostal"],$params["courriel"],$params["optin"]);
                            $modele->sauvegarde($nUsager);                            
                        }
    
                    break;    
                    
                case "ajouterCommandeAJAX":

                        if(isset($params["produitStorage"],$params["montant"]))
                        { 
                            $produits = json_decode($params["produitStorage"]);
                            $detail = "";

                            $modeleProduits = $this->obtenirDAO("Produits");
                            foreach ($produits as $produit) {
                                $detail .= $produit->nombre . " " . $produit->produit->nom . ", ";

                                // déduit l’inventaire du produits dans la table produits
                                $obProduit = $modeleProduits->obtenir_par_id($produit->produit->id);
                                $deduitInventaire = $obProduit->getInventaire()-$produit->nombre;
                                $obProduit->setInventaire($deduitInventaire);

                                $modeleProduits->sauvegarde($obProduit);

                            }
                            $detail = substr($detail, 0, strlen($detail)-2);

                            $modele = $this->obtenirDAO("Commandes");
                            $nCommande = new Commande(0, $detail, $params["montant"]);
                            $modele->sauvegarde($nCommande);
                            
                        }
    
                    break;                    

                default:
                    trigger_error("Action invalide.");
            }
        }

    }
?>
