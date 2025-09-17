<div class="group fixed top-0 left-0 h-full z-30">
    <!-- Trois traits blancs DANS la bande rouge -->
    <div class="bg-red-600 w-16 group-hover:w-56 h-full transition-all duration-300 overflow-hidden shadow-lg flex flex-col items-center pt-0">
        <div class="flex flex-col items-center mt-8 mb-8 space-y-2 transition-all duration-300">
            <span class="block w-8 h-1 bg-white rounded transition-all duration-300 group-hover:w-12"></span>
            <span class="block w-8 h-1 bg-white rounded transition-all duration-300 group-hover:w-12"></span>
            <span class="block w-8 h-1 bg-white rounded transition-all duration-300 group-hover:w-12"></span>
        </div>
        <ul class="w-full flex flex-col items-start pt-8">
            <li>
                <button class="w-0 opacity-0 group-hover:w-full group-hover:opacity-100 transition-all duration-300 cursor-pointer p-5 text-left text-lg text-white hover:bg-amber-500"
                    onclick="chargerCategorie('Menus')">Menus</button>
            </li>
            <li>
                <button class="w-0 opacity-0 group-hover:w-full group-hover:opacity-100 transition-all duration-300 cursor-pointer p-5 text-left text-lg text-white hover:bg-amber-500"
                    onclick="chargerCategorie('Plats')">Plats</button>
            </li>
            <li>
                <button class="w-0 opacity-0 group-hover:w-full group-hover:opacity-100 transition-all duration-300 cursor-pointer p-5 text-left text-lg text-white hover:bg-amber-500"
                    onclick="chargerCategorie('Legumes')">Légumes</button>
            </li>
            <li>
                <button class="w-0 opacity-0 group-hover:w-full group-hover:opacity-100 transition-all duration-300 cursor-pointer p-5 text-left text-lg text-white hover:bg-amber-500"
                    onclick="chargerCategorie('Boissons')">Boissons</button>
            </li>
            <li>
                <button class="w-0 opacity-0 group-hover:w-full group-hover:opacity-100 transition-all duration-300 cursor-pointer p-5 text-left text-lg text-white hover:bg-amber-500"
                    onclick="chargerCategorie('Desserts')">Desserts</button>
            </li>
        </ul>
    </div>
</div>