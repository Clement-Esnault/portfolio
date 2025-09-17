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
        <h2>Se connecter</h2>
        <form action="connexion/confirmation_connexion.php" method="post">
            <div class="form-group">
                <label for="email">Adresse e-mail :</label>
                <input type="email" id="email" name="email" required>
            </div>


            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
            </div>


            <button type="submit" class="submit-btn">Se connecter</button>
        </form>
    </div>
</body>
