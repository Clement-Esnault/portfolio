<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RapidC3</title>
    <link rel="stylesheet" href="styles/style.css">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="scripts/script.js" defer></script>
</head>
<body class="bg-orange-300">
      <?php include 'includes/banniere.php';?>
  <?php include 'navbar.php';?>
  <main class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg overflow-hidden">
   <div class="bg-white">

        <!-- Grille de produits -->
        <div class="grid grid-rows-2 gap-4">
            <!-- Première ligne : 3 colonnes -->
            <div class="grid grid-cols-3 gap-4 mb-4">
                <div class="bg-gray-200 p-4 rounded text-center min-w-[250px] min-h-[280px] flex flex-col items-center">
                    <img src="images/pizza.jpg" class="rounded object-cover max-h-full max-w-full flex-grow">
                    <p>Text</p>
                </div>
                <div class="bg-gray-200 p-4 rounded text-center min-w-[250px] min-h-[280px] flex flex-col items-center">
                    <img src="images/pizza.jpg" class="rounded object-cover max-h-full max-w-full flex-grow">
                    <p>Text</p>
                </div>
                <div class="bg-gray-200 p-4 rounded text-center min-w-[250px] min-h-[280px] flex flex-col items-center">
                    <img src="images/pizza.jpg" class="rounded object-cover max-h-full max-w-full flex-grow">
                    <p>Text</p>
                </div>
            </div>
            <!-- Deuxième ligne : 2 colonnes centrées -->
            <div class="grid grid-cols-2 gap-4 justify-center">
                <div class="bg-gray-200 p-4 rounded text-center min-w-[250px] min-h-[280px] flex flex-col items-center">
                    <img src="images/pizza.jpg" class="rounded object-cover max-h-full max-w-full flex-grow">
                    <p>Menu Pizza</p>
                </div>
                <div class="bg-gray-200 p-4 rounded text-center min-w-[250px] min-h-[280px] flex flex-col items-center">
                    <img src="images/Kebabacool.png" class="rounded object-cover max-h-full max-w-full flex-grow">
                    <p>Menu Kebab</p>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-6 border-gray-300">

        <!-- Carrousel -->
   <section class="bg-white">
        <h2 class="text-center text-2xl font-bold mb-4">Ils ont aimé </h2>
        
        <div class="carousel flex transition-transform duration-500">
            <div class="review-card w-full flex-shrink-0 text-center p-4">
                <div class="stars flex justify-center">
                    <svg viewBox="0 0 100 20" class="w-24 h-6">
                        <defs>
                            <linearGradient id="gold-gradient" x1="0%" y1="0%" x2="100%" y2="0%">
                                <stop offset="0%" style="stop-color: #FFD700;" />
                                <stop offset="100%" style="stop-color: #FFA500;" />
                            </linearGradient>
                        </defs>
                        <text x="0" y="15" font-size="18" fill="url(#gold-gradient)">★★★★★</text>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mt-2">Excellent Service</h3>
                <p class="text-gray-600">Super Expérience! Je recomande.</p>
                <p class="text-sm text-gray-500">Alice - <span class="font-bold">10 Juin, 2025</span></p>
            </div>

            <div class="review-card w-full flex-shrink-0 text-center p-4">
                <div class="stars flex justify-center">
                    <svg viewBox="0 0 100 20" class="w-24 h-6">
                        <text x="0" y="15" font-size="18" fill="url(#gold-gradient)">★★★★☆</text>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mt-2">Bien mais peut mieux faire</h3>
                <p class="text-gray-600">Service correcte, mais peut être plus rapide.</p>
                <p class="text-sm text-gray-500">Bob - <span class="font-bold">9 Juin 2025</span></p>
            </div>

            <div class="review-card w-full flex-shrink-0 text-center p-4">
                <div class="stars flex justify-center">
                    <svg viewBox="0 0 100 20" class="w-24 h-6">
                        <text x="0" y="15" font-size="18" fill="url(#gold-gradient)">★★★★★</text>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mt-2">Incroyable!</h3>
                <p class="text-gray-600">Meilleur expérience ! Je reviendrai.</p>
                <p class="text-sm text-gray-500">Charlie - <span class="font-bold">8 Juin 2025</span></p>
            </div>
        </div>
    </section>
  </main>
  <footer >
    <?php include 'footer.php';?>
  </footer>
  
  
            

</body>

</html>