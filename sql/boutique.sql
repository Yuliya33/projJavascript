
-- Database: boutique


CREATE TABLE produits (
	id int NOT NULL AUTO_INCREMENT,
	nom varchar(50) NOT NULL,
	prix int(4) NOT NULL,
	lienimage varchar(75) NOT NULL,
	inventaire int(6),
	PRIMARY KEY(id)
);


CREATE TABLE commandes (
	id int NOT NULL AUTO_INCREMENT,
	detail varchar(300) NOT NULL,
	montant int(4) NOT NULL,
	PRIMARY KEY(id)
);


CREATE TABLE usagers (
	id int NOT NULL AUTO_INCREMENT,
	nom varchar(50) NOT NULL,
	prenom varchar(50) NOT NULL,
	adresse varchar(75) NOT NULL,
	codepostal varchar(10) NOT NULL,
	courriel varchar(50) NOT NULL UNIQUE,
	optin int(1) NOT NULL,
	PRIMARY KEY(id)
);



INSERT INTO produits (id, nom, prix, lienimage, inventaire) VALUES
			(1, 'Bouilloire classique', 250, './assets/images/produits/bouilloire-classique.jpg', 100),
			(2, 'Bouilloire conique', 260, './assets/images/produits/bouilloire-conique.jpg', 100),
			(3, 'Assiette classique', 25, './assets/images/produits/assiette-classique.jpg', 100),
			(4, 'Assiette minimale', 18, './assets/images/produits/assiette-minimale.jpg', 100),
			(5, 'Assiette à dessert classique', 14, './assets/images/produits/assiette-classique-dessert.jpg', 100),
			(6, 'Assiette à dessert minimale', 12, './assets/images/produits/assiette-minimale-dessert.jpg', 100),
			(7, 'Assiette creuse classique', 20, './assets/images/produits/assiette-classique-creuse.jpg', 100),
			(8, 'Assiette creuse minimale', 16, './assets/images/produits/assiette-minimale-creuse.jpg', 100),
			(9, 'Petite assiette classique', 17, './assets/images/produits/assiette-petite-classique.jpg', 100),
			(10, 'Petite assiette minimale', 15, './assets/images/produits/assiette-petite-minimale.jpg', 100),
			(11, 'Bol classique', 10, './assets/images/produits/bol-classique.jpg', 100),
			(12, 'Bol minimal', 8, './assets/images/produits/bol-minimal.jpg', 100),
			(13, 'Bol soupe à l''oignon', 42, './assets/images/produits/bol-soupe-oignon.jpg', 100),
			(14, 'Bol de service classique', 125, './assets/images/produits/bol-service-classique.jpg', 100),
			(15, 'Bol de service minimal', 100, './assets/images/produits/bol-service-minimale.jpg', 100),
			(16, 'Tasse à café classique', 22, './assets/images/produits/tasse-cafe-classique.jpg', 100),
			(17, 'Tasse à café minimale', 19, './assets/images/produits/tasse-cafe-minimale.jpg', 100),
			(18, 'Plateau minimal', 300, './assets/images/produits/plateau-minimal.jpg', 100),
			(19, 'Plateau ovale', 320, './assets/images/produits/plateau-ovale.jpg', 100),
			(20, 'Beurrier', 60, './assets/images/produits/beurrier.jpg', 100),
			(21, 'Beurrier breton', 75, './assets/images/produits/beurrier-breton.jpg', 100),
			(22, 'Pichet classique', 95, './assets/images/produits/pichet-classique.jpg', 100),
			(23, 'Pichet minimal', 80, './assets/images/produits/pichet-minimal.jpg', 100),
			(24, 'Saucière', 65, './assets/images/produits/sauciere.jpg', 100),
			(25, 'Grande théière', 70, './assets/images/produits/theiere-grande.jpg', 100),
			(26, 'Cafetiere à piston', 160, './assets/images/produits/cafetiere-piston.jpg', 100),
			(27, 'Crémier et sucrier classique', 50, './assets/images/produits/cremier-sucrier-classique.jpg', 100),
			(28, 'Crémier et sucrier minimal', 35, './assets/images/produits/cremier-sucrier-minimal.jpg', 100),
			(29, 'Pot à sel', 55, './assets/images/produits/pot-sel.jpg', 100),
			(30, 'Ramequin', 7, './assets/images/produits/ramequin.jpg', 100);



INSERT INTO commandes (id, detail, montant) VALUES
			(1, '2 Ramequin, 1 Beurrier', 74);



INSERT INTO usagers (id, nom, prenom, adresse, courriel, optin) VALUES
			(1, 'Plante', 'Mathieu', '1347 rue Cartier', 'mathieu.plante@gmail.com', 0),
			(2, 'Gervais', 'Madeline', '392 rue des Pinsons', 'madeline05@yahoo.com', 1);
