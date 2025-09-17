<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Simple</title>
    <link rel="stylesheet" href="styles/style.css">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .fade-in {
            animation: fadeIn 0.2s ease-out forwards;
        }
    </style>
</head>

<body class="bg-orange-300">
<?php include 'banniere.php';?>

    <nav>
         <?php include('navbar.php');?>
    </nav>
    <main class="flex">
      <?php include('sideBar.php'); ?>
        
      <div class="content justify-center" id="resultat">
        <div id="plats-items" class="category-container"></div>
        <div id="legumes-items" class="category-container"></div>
        <div id="boissons-items" class="category-container"></div>
        <div id="desserts-items" class="category-container"></div>
      </div>
      <?php include('cart-icon.php'); ?>
    </main>
        
    <footer >
        <?php include('footer.php'); ?>
    </footer>
    <script>
        console.log('Script cart.js chargé avec succès !');
        console.log(document.querySelectorAll('#resultat button'));

        document.addEventListener('DOMContentLoaded', () => {
            chargerCategorieMenu("Plats");
            chargerCategorieMenu("Legumes");
            chargerCategorieMenu("Boissons");
            chargerCategorieMenu("Desserts");
        });



    function chargerCategorie(categorie) {
      fetch('menus-plats.php?categorie=' + categorie)
        .then(response => response.text())
        .then(html => {
          document.getElementById('resultat').innerHTML = html;
        })
        .catch(error => {
          document.getElementById('resultat').innerHTML = "Erreur de chargement.";
          console.error('Erreur AJAX :', error);
        });
    }
    function chargerCategorieMenu(categorieMenu) {
        fetch('menus-plats.php?categorieMenu=' + categorieMenu)
        .then(response => response.json())  // Traite la réponse comme un JSON
        .then(data => {
            console.log(data);  // Vérifie si les données sont correctes

            let container = document.getElementById(categorieMenu.toLowerCase() + '-items');
            container.innerHTML = ''; // Vide le conteneur avant de charger de nouvelles données

            // Si les données sont vides ou contiennent une erreur
            if (!data || data.length === 0) {
                container.innerHTML = `<p>Aucun plat trouvé dans cette catégorie.</p>`;
                return;
            }

            // Affiche les items dans le conteneur
            data.forEach(item => {
                const div = document.createElement('div');
                div.classList.add('category-item');
                div.innerHTML = `
                    <span>${item.pla_nom} - ${item.prix}€</span>
                    <button onclick="add_wallet(${item.pla_num})">Ajouter au panier</button>
                `;
                container.appendChild(div);
            });
        })
        .catch(error => {
            console.error('Erreur de chargement des catégories:', error);
        });
    }


    
    function add_wallet(id) {
        console.log(id)
      fetch('panier/ajouterPlat.php?product_id=' + id + '&quantity=1')
        .then(response => response.text())
    }

    var ident = getId(id);
    function getId(id) {
        return id;
    }

  </script>
</body>

</html>