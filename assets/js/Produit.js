class Produit
{
    constructor(produit, produitClick)
    {
        this._el = document.createElement("div");
        this._el.classList.add("produit"); 
        if(produit.inventaire <= 0)
        {
            this._el.classList.add("vide");
        }
        
        this._el.setAttribute("data-js-produit",produit.id);

        this._el.innerHTML = 
        `
            <picture>
                <img src="${produit.lienimage}" alt="">
            </picture>

            <div class="description">
                <h3 data-js-produit-nom="${produit.nom}">${produit.nom}</h3>
                <h2 data-js-produit-prix="${produit.prix}">$${produit.prix}</h2>    
            </div> `;

        this._el.addEventListener("click", produitClick);

    }
}