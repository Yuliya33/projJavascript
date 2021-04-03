window.addEventListener("DOMContentLoaded", () => 
{   
    if(sessionStorage.getItem("produit-storage"))
    {
        let panier = document.querySelector(".panier svg");
        panier.classList.add("panier-rempli");

        const produitsNombre = JSON.parse(sessionStorage.getItem("produit-storage")).length;
        document.querySelector("[data-js-nombre-panier]").innerHTML = produitsNombre;
    }    

    if(document.querySelector("[data-js-panier]") == null)
    {
        new GestionProduits();
    }  
    else
    {
        new Panier(document.querySelector("[data-js-panier]"));
    }
    
});