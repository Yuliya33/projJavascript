class GestionProduits
{
    constructor()
    {
        this._parentProduits = document.querySelector("[data-js-parent-produits]");
        this._ordre = document.querySelector("[data-js-ordre]");

        this._btnFiltrer = document.querySelector("[data-js-btn-filtrer]");
        this._btnVoirPlus = document.querySelector("[data-js-btn-voir-plus]");        
        this._numeroPage = 0;
        this._nombreProduits = 12;

        this._btnFiltrer.addEventListener("click", this.btnFiltrerClick);
        this._btnVoirPlus.addEventListener("click", this.btnVoirPlusClick);

        let tuiles = document.querySelectorAll("[data-js-produit]");
        for(let i=0; i<tuiles.length; i++)
        {
            tuiles[i].addEventListener("click", this.produitClick);
        }

        this._nombrePanier = document.querySelector("[data-js-nombre-panier]");
        this._panierImage = this._nombrePanier.nextElementSibling;
        if(sessionStorage.getItem("produit-storage"))
        {
            this._produitStorage = JSON.parse(sessionStorage.getItem("produit-storage"));
        }
        else
        {
            this._produitStorage = [];
        }

        this.miseAJourNombrePanier();
        
    }

    pageSuivante = () =>
    {
        this._numeroPage++;
    }

    btnFiltrerClick = () =>
    {
        this._numeroPage = 0;
        this._parentProduits.innerHTML = "";
        this._btnVoirPlus.style.display = "block";
        this.obtenirProduit();
    }

    btnVoirPlusClick = () => 
    {
        this.pageSuivante();  
        this.obtenirProduit();      
    }

    produitClick = (evt) =>
    {
        //trouve le parent dans la tuile
        let parent;
        for(let i=0; i<evt.path.length-2; i++)
        {
            if(evt.path[i].dataset.jsProduit)
            {
                parent = evt.path[i];
                break;
            }
        }

        if(!parent.classList.contains("vide"))
        {
            //collecte l'information de produit pour ajouter au panier
            let produit = 
            {
                'id': parent.dataset.jsProduit,
                'lienimage': parent.querySelector("img").src,
                'nom': parent.querySelector("[data-js-produit-nom]").dataset.jsProduitNom,
                'prix': parent.querySelector("[data-js-produit-prix]").dataset.jsProduitPrix
            }
    
            this.ajouterProduitPanier(produit);
        }

    }

    ajouterProduitPanier = (produit) => 
    {
        for(let i=0, produitStorage = this._produitStorage; i<produitStorage.length; i++)
        {     
            //augmente le nombre d'un produit dans le panier s'il etait deja là       
            if(JSON.stringify(produitStorage[i].produit) == JSON.stringify(produit))
            {
                produitStorage[i].nombre++;
                sessionStorage.setItem("produit-storage", JSON.stringify(this._produitStorage));
                return;
            }
        }
        //ajoute un produit
        this._produitStorage.push({'produit': produit, nombre: 1});        
        sessionStorage.setItem("produit-storage", JSON.stringify(this._produitStorage));

        this.miseAJourNombrePanier();

    }

    miseAJourNombrePanier = () =>
    {
        let nombre;
        if(this._produitStorage.length != 0)
        {
            nombre = this._produitStorage.length;
            this._panierImage.classList.add("panier-rempli");
        }
        else
        {
            nombre = "";
        }
        
        this._nombrePanier.innerHTML = nombre;        
    }    

    numeroCourant = () => 
    {
        return this._nombreProduits*this._numeroPage;
    }

    obtenirProduit = () =>
    {    
        //obtient les prochaine 12 produits    
        let nombreProduits = this._nombreProduits;
        let btnVoirPlus = this._btnVoirPlus;
        let parentProduits = this._parentProduits;

        let produitClick = this.produitClick;

        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {  
            let jsonProduits = JSON.parse(this.response); 

            for(let i=0; i<jsonProduits.length; i++)
            {
                const produit = jsonProduits[i];
                parentProduits.appendChild(new Produit(produit, produitClick)._el);
            }
            if(jsonProduits.length < nombreProduits)
            {                
                btnVoirPlus.style.display = "none";
            }
          }
        };
        xhttp.open("GET", "index.php?Produits&cmd=obtenirProduitsAJAX&numeroCourant="+this.numeroCourant()+"&nombreProduits="+this._nombreProduits+"&ordre="+this._ordre.value, true);
        xhttp.send();
    }
}