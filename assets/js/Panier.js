class Panier
{
    constructor(parent)
    {
        this._produitStorage = JSON.parse(sessionStorage.getItem("produit-storage"));
        if(this._produitStorage)
        {            
            this._el = document.createElement("div");
            this._el.classList.add("tableau-panier");
            let html = 
                      `<div class="ligne">                            
                            <div class="colonne">
                                <h2>Nom</h2>
                            </div>
                            <div class="colonne">
                                <h2>Prix</h2>
                            </div>
                            <div class="colonne">
                                <h2>Nombre</h2>
                            </div>
                            <div class="colonne">
                                <h2>Total</h2>
                            </div>
                        </div>`;
            for(let i=0; i<this._produitStorage.length; i++)
            {
                let produit = this._produitStorage[i].produit;
                html+= 
                `
                <div class="ligne" data-js-id-produit="${produit.id}">
                    <div class="colonne">
                        <p>${produit.nom}</p>
                    </div>
                    <div class="colonne">
                        <p data-js-produit-prix>${produit.prix}</p>
                    </div>
                    <div class="colonne">
                        <input type="number" value="${this._produitStorage[i].nombre}" min="0" data-js-produit-nombre>
                    </div>
                    <div class="colonne">
                        <p data-js-produit-total>${produit.prix*this._produitStorage[i].nombre}</p>
                    </div>
                </div>
                `;
            }

            this._el.innerHTML = html;
            
            this._elPasserCommande = document.createElement("div");
            this._elPasserCommande.classList.add("passer-commande");
            this._elPasserCommande.innerHTML = 
                                                `<div class="passer-commande">
                                                    <h1 data-js-produits-total>Total: ${this.calculeTotal()}</h1>
                                                    <button data-js-btn-passer-commande>Passer la commande</button>
                                                </div>`;

            parent.appendChild(this._el);
            parent.appendChild(this._elPasserCommande);

            this._elPasserCommande.querySelector("[data-js-btn-passer-commande]").addEventListener("click", () => 
            {
                const total = this.calculeTotal();
                if(total > 0)
                {
                    let parent = this._el.parentNode;
                    parent.innerHTML = "";
                    let formulaire = new Formulaire(total); 
                    parent.appendChild(formulaire._el);
                }
            });

            let elsProduitNombre = this._el.querySelectorAll("[data-js-produit-nombre]");
            for(let i=0; i<elsProduitNombre.length; i++)
            {
                let produitsTotal = this._elPasserCommande.querySelector("[data-js-produits-total]");
                elsProduitNombre[i].addEventListener("change", (evt) => 
                {
                    let elGrandParent = evt.target.parentNode.parentNode;
                    let idProduit = elGrandParent.dataset.jsIdProduit;
                    let prix = elGrandParent.querySelector("[data-js-produit-prix]").innerHTML;
                    let nombre = evt.target.value;

                    //mise à jour dans les 'total'
                    elGrandParent.querySelector("[data-js-produit-total]").innerHTML = prix*nombre;
                    produitsTotal.innerHTML = `Total: ${this.calculeTotal()}`;

                    //mise à jour dans le sessionStorage(nombre de produit)
                    for(let i=0; i<this._produitStorage.length; i++)
                    {
                        if(this._produitStorage[i].produit.id == idProduit)
                        {
                            this._produitStorage[i].nombre = nombre;
                            sessionStorage.setItem("produit-storage", JSON.stringify(this._produitStorage));
                        }
                        
                    }



                });
            }
        }
        else
        {
            parent.innerHTML = "<div class='tableau-panier'><h1>Panier est vide</h1></div>";
        }


    }

    calculeTotal = () => 
    {
        let total = 0;
        let elsTotal = this._el.querySelectorAll("[data-js-produit-total]");
        for(let i=0; i<elsTotal.length; i++)
        {
            total += parseInt(elsTotal[i].innerHTML);
        }

        return total;        
    }
}