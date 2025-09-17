<!DOCTYPE html>
<html lang="fr">
    <head>
      <meta charset="UTF-8">
      <title>Dashboard Gérant - Accueil</title>
      <link rel="stylesheet" href="style.css">
    </head>

    <body>
      <header class="banniere">Bienvenue sur le Dashboard Gérant</header>

      <div class="nav-left z-20">
        <li><a href="../index.php">Accueil</a></li>
        <li><a href="../menu.php">Notre Carte</a></li>
      </div>
      <div class="nav-right">
          <?php
          session_start();
          if(isset($_SESSION['is_logged_in'])){
              echo "<p>Bienvenue ".$_SESSION['nom']."</p>";
              if(isset($_SESSION['gerant']) && $_SESSION['gerant'] == 1){
                  echo '<li id="inscription"><a href="dashboard.php">Dashboard</a></li>';
              }
              echo '<li id="inscription"><a href="../deconnexion/deconnexion.php">Se Déconnecter</a></li>';
          } else{
              $text = "S'inscrire";
              echo '<li id="inscription"><a href="../creerUnCompte.php">'.$text.'</a></li>
              <li id="connexion"><a href="../seConnecter.php">Se Connecter</a></li>';
          }
          ?>
      </div>

      <main class="dashboard-grid">
        <div class="dashboard-block">
          <a href="dashboard-cli.php" class="block-title">👥 Configuration Clients</a>
          <div class="block-stats">
            <p>Nombre de clients : <strong>124</strong></p>
            <p>Clients fidèles : <strong>47</strong></p>
          </div>
        </div>

        <div class="dashboard-block">
          <a href="dashboard-com.php" class="block-title">📦 Configuration Commandes</a>
          <div class="block-stats">
            <p>Commandes aujourd’hui : <strong>53</strong></p>
            <p>En cours : <strong>12</strong></p>
          </div>
        </div>

        <div class="dashboard-block">
          <a href="dashboard-res.php" class="block-title">🍽️ Configuration Restaurant</a>
          <div class="block-stats">
            <p>Tables disponibles : <strong>8</strong></p>
            <p>Équipe en service : <strong>5</strong></p>
          </div>
        </div>

        <div class="dashboard-block">
          <a href="dashboard-red.php" class="block-title">🎁 Configuration Réduction</a>
          <div class="block-stats">
            <p>Points distribués : <strong>1230</strong></p>
            <p>Récompenses actives : <strong>4</strong></p>
          </div>
        </div>
      </main>

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