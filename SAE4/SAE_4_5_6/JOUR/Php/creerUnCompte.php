<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Simple</title>
    <link rel="stylesheet" href="styles/style.css">
</head>

<body class="compte">
   
    <div class="container">
        <h2>Créer un compte</h2>
        <form action="testincsri.php" method="post">
            <div class="form-group">
                <label for="prenom">Prénom* :</label>
                <input type="text" id="prenom" name="prenom" required>
            </div>


            <div class="form-group">
                <label for="nom">Nom* :</label>
                <input type="text" id="nom" name="nom" required>
            </div>


            <div class="form-group">
                <label for="email">Adresse e-mail* :</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="tel">Numéro de Téléphone* :</label>
                <input type="tel" id="tel" name="tel" pattern="[0-9]{10}" required>
            </div>

            <div class="form-group">
                <label for="mdp">Mot de passe* :</label>
                <input type="password" id="mdp" name="mdp" required>
            </div>


            <p>* obligatoire</p>

            <button type="submit" class="submit-btn">Créer un compte</button>
        </form>
    </div>
</body>
