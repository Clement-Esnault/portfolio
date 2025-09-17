<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RapidC3 - Panier</title>
    <link rel="stylesheet" href="styles/style.css">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="scripts/script.js" defer></script>

</head>
<body class="bg-orange-300 ">
  <?php include 'includes/banniere.php';?>
  <?php include 'navbar.php';?>
  <main class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-8">
    <h2 class="text-2xl font-bold mb-6 text-center">Votre Panier</h2>
    <div class="overflow-x-auto">
      <table class="min-w-full bg-gray-100 rounded-lg overflow-hidden">
        <thead>
          <tr>
            <th class="px-4 py-2 text-left">Produit</th>
            <th class="px-4 py-2 text-center">Quantité</th>
            <th class="px-4 py-2 text-center">Prix Unitaire</th>
            <th class="px-4 py-2 text-center">Total</th>
          </tr>
        </thead>
        <tbody id="cart-body">
        <?php
          include "connection.php";

          $conn = OuvrirConnexionPDO($db,$db_username,$db_password);
          $tab = $_SESSION['wallet'];
          $_SESSION['total'] = 0;
          foreach ($tab as $key => $value) {
            $tab_sql = [];
            $sql = "select pla_nom, pla_prix_vente_unit_ht from rap_plat where pla_num = trim('".$key."')";
            LireDonneesPDO1($conn, $sql, $tab_sql);
            foreach ($tab_sql as $ligne) {
              $valeurs = array_values($ligne);
              if (strpos($valeurs[1], '.') === 0) {
                $valeurs[1] = '0' . $valeurs[1];
              }
              $valeurs[1] = str_replace(',', '.', $valeurs[1]);
              echo "<tr><td>".$valeurs[0]."</td><td>".$value."</td><td>".$valeurs[1]." €</td><td>".$value*$valeurs[1]." €</td></tr>";
              $_SESSION['total'] = $_SESSION['total']+$value*$valeurs[1];
            }
          }
        ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="3" class="text-right px-4 py-3 font-bold text-lg">Total</td>
            <td class="text-center px-4 py-3 font-bold text-2xl text-orange-700"><?php echo $_SESSION['total'] ?> €</td>
          </tr>
        </tfoot>
      </table>
    </div>
    <div class="mt-6 text-center">
      <button class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-6 rounded transition"><a href="valider_commande.php">Commander</a></button>
    </div>
  </main>
  <?php include 'footer.php';?>
</body>
</html>