
<div class="containeur filtre">
    <div>
        <label for="ordre">Filtre par</label>
        <select name="ordre" id="ordre" data-js-ordre>
            <option value="">Сhoisir l'ordre</option>
            <option value="nom">Alphabétique</option>
            <option value="prix">Prix</option>
        </select>
    </div>

    <div>
        <button data-js-btn-filtrer> Soummetre </button>
    </div>
</div>

<main class="containeur produits" data-js-parent-produits>

    <?php $produits = $donnees["produits"];
    foreach($produits as $produit):
    ?>

    <div class="produit <?= $produit->getInventaire() <= 0 ? "vide": "" ?>" data-js-produit="<?=$produit->getId()?>">

        <picture>
            <img src="<?=$produit->getLienImage()?>" alt="">
        </picture>

        <div class="description">
            <h3 data-js-produit-nom="<?=$produit->getNom()?>"><?=$produit->getNom()?></h3>
            <h2 data-js-produit-prix="<?=$produit->getPrix()?>">$<?=$produit->getPrix()?></h2>    
        </div>

    </div>


    <?php endforeach?>

</main>

<footer class="containeur">
    <button class="btn-voir-plus" data-js-btn-voir-plus> Voir plus </button>
</footer>

