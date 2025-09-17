<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Simple</title>
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

<body>
    <div id="modal" class="fixed inset-0 hidden justify-center items-center z-50">
        <div class="flex justify-center items-center h-full w-full">
            <div class="bg-white rounded-lg p-8 w-1/2 fade-in" role="group">
                <div class="flex justify-center items-center h-full w-full">
                    <div class="inline-flex rounded-md shadow-xs">
                        <button type="button" id="Plat"
                            class="btn px-4 py-2 tet-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s-lg hover:text-red-700 hover:bg-gray-100  focus:z-10 focus:ring-2 focus:ring-red-700 focus:text-red-700">Plats</button>
                        <button type="button" id="Legume"
                            class="btn px-4 py-2 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-200  hover:text-red-700 hover:bg-gray-100  focus:z-10 focus:ring-2 focus:ring-red-700 focus:text-red-700">Légumes</button>
                        <button type="button" id="Boisson"
                            class="btn px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 hover:text-red-700 hover:bg-gray-100  focus:z-10 focus:ring-2 focus:ring-red-700 focus:text-red-700">Boissons</button>
                        <button type="button" id="Dessert"
                            class="btn px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-e-lg hover:text-red-700 hover:bg-gray-100  focus:z-10 focus:ring-2 focus:ring-red-700 focus:text-red-700">Desserts</button>
                    </div>
                </div>
                <div class="mt-8 flex justify-center items-right h-full w-full">
                    <button type="button" id="Close"
                        class="bg-red-500 text-white px-4 py-2 rounded font-bold mr-8">Annuller</button>
                    <button type="button" class="bg-green-500 text-white px-4 py-2 rounded font-bold">valider</button>
                </div>


            </div>
        </div>
    </div>
    <button id="open" class="border-solid border-3">test button</button>

    <script>
        
        document.addEventListener('DOMContentLoaded', () => {
            const openBtn = document.getElementById('open');
            const closeBtn = document.getElementById('Close');
            const modal = document.getElementById('modal');
            openBtn.addEventListener('click', () => {
                modal.classList.remove('hidden');
            })

            closeBtn.addEventListener('click', () => {
                modal.classList.add('hidden');
            })
        })

    </script>
</body>

</html>