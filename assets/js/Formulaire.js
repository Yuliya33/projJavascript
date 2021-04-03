class Formulaire
{
    constructor(total)
    {
        this._produitStorage = sessionStorage.getItem("produit-storage");
        this._total = total;

        this._el = document.createElement("form");
        this._el.classList.add("formulaire");

        this._el.innerHTML = 
        `
        <div>
            <label>Nom*</label>
            <input type="text" name="nom">
        </div>

        <div>
            <label>Prénom*</label>
            <input type="text" name="prenom">
        </div>

        <div>
            <label>Adresse*</label>
            <input type="text" name="adresse">
        </div>

        <div>
            <label>Code postal*</label>
            <input type="text" name="codepostal" data-js-validation-code-postal>
        </div>

        <div>
            <label>Courriel*</label>
            <input type="email" name="courriel" data-js-validation-courriel>
        </div>

        <div class="infolettre">
            <label>Inscription à l'infolettre</label>
            <input type="checkbox" name="optin">
        </div>

        <div class="carte-credit">
            <label>Carte de crédit*</label>
            <input type="text" name="carteCredit" data-js-validation-carte-credit>
        </div>
        
        <div>
            <label>Expiration*</label>
            <input type="date" name="expiration">
        </div>
        
        <div>
            <label>Code de sécurité*</label>
            <input type="text" name="codeSecurite">
        </div>    

        <div>
            <button data-js-commander>Commander</button>
        </div>
        
        
        `;

        this._elsInput = this._el.querySelectorAll("input");
        this._elBtnCommander = this._el.querySelector("[data-js-commander]");
        this._elBtnCommander.addEventListener("click", this.btnCommanderClick);
        
    }

    btnCommanderClick = (evt) => 
    {
        let obFormulaire = this;

        evt.preventDefault();
        if(this.validate())
        { 
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {  
                
                let reponseJSON = JSON.parse(this.responseText);
                if(!reponseJSON)
                {
                    //ajoute l'usager s'il n'existe pas dans la BD
                    obFormulaire.ajouterUsager();                     
                }

                obFormulaire.ajouterCommande();

                obFormulaire._el.parentNode.innerHTML = "<div class='continuer-votre-visite'><h1>Merci!</h1><a href='index.php'>Continuer votre visite</a></div>";
                sessionStorage.removeItem("produit-storage");
                
                setTimeout(() => 
                {
                    window.location = "index.php";
                },5000);
                
              }
            };
            xhttp.open("GET", "index.php?Produits&cmd=verifierCourrielAJAX&courriel="+this._el.courriel.value, true);
            xhttp.send();   


        }

    }

    //validation d'un formulaire
    validate = () => 
    {
        let valide = true; 
        for(let i=0; i<this._elsInput.length; i++)
        {
            let elInput = this._elsInput[i];
            if(elInput.value == "")
            {                
                valide = false;
                elInput.classList.add("erreur-validation");
            }
            else
            {
                elInput.classList.remove("erreur-validation");
            }
            
            if(elInput.dataset.jsValidationCodePostal != undefined)
            {
                let regex = /^[a-zA-Z]\d[a-zA-Z]\d[a-zA-Z]\d$/;
                if(!regex.test(elInput.value))
                {
                    valide = false;
                    elInput.classList.add("erreur-validation");
                }
                else
                {
                    elInput.classList.remove("erreur-validation");
                }                
            }

            if(elInput.dataset.jsValidationCourriel != undefined)
            {
                let regex = /^[a-zA-Z-_.]*@[a-zA-Z]*.[a-zA-Z]*/;
                if(!regex.test(elInput.value))
                {
                    valide = false;
                    elInput.classList.add("erreur-validation");
                }
                else
                {
                    elInput.classList.remove("erreur-validation");
                }                                
            }

            if(elInput.dataset.jsValidationCarteCredit != undefined)
            {
                let regexVisa = /^4[0-9]{12}(?:[0-9]{3})?$/;
                let regexMaster = /^(?:5[1-5][0-9]{2}|222[1-9]|22[3-9][0-9]|2[3-6][0-9]{2}|27[01][0-9]|2720)[0-9]{12}$/;
                if(!regexVisa.test(elInput.value) && !regexMaster.test(elInput.value))
                {
                    valide = false;
                    elInput.classList.add("erreur-validation");
                }
                else
                {
                    elInput.classList.remove("erreur-validation");
                }                 
                
            }

        }

        return valide;

    }

    //ajoute l'usager dans BD
    ajouterUsager = () => 
    {

        let formulaire = this._el;

        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) 
            {
                                
            }
        };
        xhttp.open("POST", `index.php?Produits&cmd=ajouterUsagerAJAX`,true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        let optin;
        formulaire.optin.checked ? optin = 1 : optin = 0;
        xhttp.send(`nom=${formulaire.nom.value}&prenom=${formulaire.prenom.value}&adresse=${formulaire.adresse.value}&codepostal=${formulaire.codepostal.value}&courriel=${formulaire.courriel.value}&optin=${optin}`, true);
    }
    //ajoute la commande dans la BD
    ajouterCommande = () => {

        let formulaire = this._el;

        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) 
            {
                                
            }
        };
        xhttp.open("POST", `index.php?Produits&cmd=ajouterCommandeAJAX`,true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
        xhttp.send(`produitStorage=${this._produitStorage}&montant=${this._total}`, true);
    }
}