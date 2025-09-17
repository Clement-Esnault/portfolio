   <ul class="nav-links">
    <div class="nav-left z-20">
        <li><a href="index.php">Accueil</a></li>
        <li><a href="menu.php">Notre Carte</a></li>
    </div>
    <div class="nav-right">
        <?php
        session_start();
        if(isset($_SESSION['is_logged_in'])){
            echo "<p>Bienvenue ".$_SESSION['nom']."</p>";
            if(isset($_SESSION['gerant']) && $_SESSION['gerant'] == 1){
                echo '<li id="inscription"><a href="dashboard/dashboard.php">Dashboard</a></li>';
            }
            echo '<li id="inscription"><a href="deconnexion/deconnexion.php">Se Déconnecter</a></li>';
        } else{
            $text = "S'inscrire";
            echo '<li id="inscription"><a href="creerUnCompte.php">'.$text.'</a></li>
            <li id="connexion"><a href="seConnecter.php">Se Connecter</a></li>';
        }
        ?>
    </div>
</ul>