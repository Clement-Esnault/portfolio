<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Gestion des Clients</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <header class="banniere">Gestion des Clients</header>
  
  <div class="header-container">
  <h1>Liste des clients</h1>

  <div class="search-container">
    <input type="text" id="searchInput" class="search-input" placeholder="Rechercher un client..." onkeyup="filterTable()">
  </div>
</div>


  <main>
    <table class="clients-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nom</th>
          <th>Prénom</th>
          <th>Email</th>
          <th>Téléphone</th>
          <th>Actions</th>
          <th>Gestion</th>
          <th>Commander</th>
        </tr>
      </thead>
      <tbody id="client-list">
        <?php

          include_once "voir_commande.php";


          include_once "../connection.php";

          $conn = OuvrirConnexionPDO($db,$db_username,$db_password);

          $tab = [];
          $sql = "select cli_num,cli_nom, cli_prenom, cli_courriel, cli_tel from rap_client where est_gerant <> '1'";
          
          LireDonneesPDO1($conn, $sql, $tab);
          foreach ($tab as $ligne) {
            $valeurs = array_values($ligne);
            if (isset($valeurs[0]) && isset($valeurs[1]) && isset($valeurs[2]) && isset($valeurs[3]) && isset($valeurs[4])) {
              echo '<tr>
                <td>'.$valeurs[0].'</td>
                <td>'.$valeurs[1].'</td>
                <td>'.$valeurs[2].'</td>
                <td>'.$valeurs[3].'</td>
                <td>'.$valeurs[4].'</td>
                <td>
                <form method="GET" action="voir_commande.php">
                  <input type="hidden" id ="id" name="id" value="'.$valeurs[0].'">
                  <button type="submit" class="toggle-commandes">Voir commandes</button>
                </form>
                </td>
                <td>
                      <button class="modifier">Modifier</button>
                      <button class="supprimer">Supprimer</button>
                </td>
                <td>
                  <button class="toggle-commander"> Commander </button>
                </td>
          
              </tr>
              <tr>
                <div id = "zone-affichage">
                  <?php AfficherDonnee1($tab); ?>
                </div>
              </tr>
           ';
            }
          }
        ?>
      </tbody>
    </table>
  </main>

    <!--Si modif client-->
    <div id="form-modifier" class="modal hidden">
    <div class="modal-content">
      <h2>Modifier le client</h2>
      <form action = "modification_client.php" method="POST">
        <input  type="hidden" name="e-id" id="e-id" />
        <label>Nom : <input type="text" id="edit-nom" name="edit-nom"></label><br>
        <label>Prenom : <input type="text" id="edit-prenom" name="edit-prenom"></label><br>
        <label>Email : <input type="email" id="edit-email" name="edit-email"></label><br>
        <label>Téléphone : <input type="text" id="edit-tel"name="edit-tel"></label><br>
        <button type="submit">Enregistrer</button>
        <button type="button" class="close-modal">Annuler</button>
      </form>
    </div>
  </div>

  <!--Si suppr client-->
  <div id="confirm-suppression" class="modal hidden">
    <div class="modal-content">
      <h2>Êtes-vous sûr de vouloir supprimer ce client ?</h2>
      <!-- Formulaire de suppression -->
      <form action="suppression_client.php" method="POST">
        <!-- Champ caché pour l'ID du client -->
        <input  type="text" name="id" id="s-id" />
        <button type="submit" class="confirmer">Oui, supprimer</button>
      </form>
      <button class="close-modal">Annuler</button>
    </div>
</div>


  <script src="script12.js"></script>
</body>
</html>