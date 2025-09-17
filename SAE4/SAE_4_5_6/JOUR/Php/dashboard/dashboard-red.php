<!DOCTYPE html>
<html lang="fr"><head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Page Simple</title>
        <link rel="stylesheet" href="style-red.css">
    </head>

    <body>
        <header class="banniere">Gestion de la Fidélité - Restaurant</header>

        <div class="main-content">
          <h1>Gestion des Promotions et des Plats</h1>


          <div class="recherche-plat">
            <label for="search-plat">Recherche un plat :</label>
            <input type="text" id="search-plat" placeholder="Rechercher un plat...">
            <button id="search-btn">Rechercher</button>
          </div>


          <div id="plats-list">
            <h2>Plats disponibles</h2>
            <table class="clients-table">
              <thead>
                <tr>
                  <th>Nom du plat</th>
                  <th>Ancien prix</th>
                  <th>Nouveau prix</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody id="plats">
                <tr>
                  <td>Pizza Margherita</td>
                  <td>12€</td>
                  <td><input type="text" value="10€" /></td>
                  <td><button class="apply-promo">Appliquer promo</button></td>
                </tr>
                <tr>
                  <td>Pasta Carbonara</td>
                  <td>15€</td>
                  <td><input type="text" value="13€" /></td>
                  <td><button class="apply-promo">Appliquer promo</button></td>
                </tr>
              </tbody>
            </table>
          </div>


          <div class="form-container">
            <h2>Envoyer un message</h2>
            <form action="#" method="POST">

              <div class="form-group">
                <label for="objet-mail">Objet</label>
                <input type="text" id="objet-mail" objetMail="objet-mail" placeholder="Entrez l'objet du mail" required>
              </div>

              <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" placeholder="Entrez votre message" rows="5" required></textarea>
                <small class="hint">Veuillez fournir des détails clairs et concis.</small>
              </div>
          
              <button type="submit">Soumettre</button>
            </form>
          </div>    
        </div>
        
      <footer class="footer">
          <div class="footer-content">
              <div class="footer-column">
                  <h4>À propos</h4>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
              </div>
              <div class="footer-column">
                  <h4>Services</h4>
                  <p>Web design, Développement, SEO</p>
              </div>
              <div class="footer-column">
                  <h4>Contact</h4>
                  <p>Email: contact@example.com</p>
                  <p>Téléphone: 0123 456 789</p>
              </div>
          </div>
          <div class="footer-bottom">
              © 2025 MonSite. Tous droits réservés.
          </div>
      </footer>
    </body>  
</html>