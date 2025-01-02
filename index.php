<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameVault - Accueil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">
    <nav class="bg-gray-800 fixed w-full z-10">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold">GameVault</h1>
                    <div class="ml-10 flex items-center space-x-4">
                        <a href="#" class="text-gray-300 hover:text-white px-3 py-2">Accueil</a>
                        <a href="#" class="text-gray-300 hover:text-white px-3 py-2">Jeux</a>
                        <a href="#" class="text-gray-300 hover:text-white px-3 py-2">Chat</a>
                    </div>
                </div>
                <div class="flex items-center">
                    <button class="bg-purple-600 hover:bg-purple-700 px-4 py-2 rounded-lg mr-4">
                        Connexion
                    </button>
                    <button class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg">
                        Inscription
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <div class="pt-16">
        <div class="relative bg-gray-800 h-[500px]">
            <div class="absolute inset-0 bg-gradient-to-r from-purple-900 to-transparent"></div>
            <div class="relative max-w-7xl mx-auto py-24 px-4">
                <h2 class="text-4xl font-bold mb-4">Gérez votre collection de jeux</h2>
                <p class="text-xl text-gray-300 mb-8">Rejoignez notre communauté de gamers et partagez votre passion</p>
                <button class="bg-purple-600 hover:bg-purple-700 px-6 py-3 rounded-lg text-lg">
                    Commencer maintenant
                </button>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-12">
        <h2 class="text-3xl font-bold mb-8">Jeux populaires</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-gray-800 rounded-lg overflow-hidden">
                <img src="https://via.placeholder.com/300x200" alt="Game" class="w-full">
                <div class="p-4">
                    <h3 class="font-bold mb-2">Elden Ring</h3>
                    <div class="flex items-center text-yellow-500 mb-2">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <span class="ml-2 text-white">5.0</span>
                    </div>
                    <p class="text-gray-400">Action RPG</p>
                </div>
            </div>

        </div>
    </div>

    <div class="bg-gray-800 py-12">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl font-bold mb-8 text-center">Fonctionnalités</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <i class="fas fa-gamepad text-4xl text-purple-500 mb-4"></i>
                    <h3 class="text-xl font-bold mb-2">Gestion de Collection</h3>
                    <p class="text-gray-400">Organisez et suivez votre collection de jeux</p>
                </div>
                <div class="text-center">
                    <i class="fas fa-comments text-4xl text-blue-500 mb-4"></i>
                    <h3 class="text-xl font-bold mb-2">Chat Communautaire</h3>
                    <p class="text-gray-400">Discutez avec d'autres joueurs</p>
                </div>
                <div class="text-center">
                    <i class="fas fa-star text-4xl text-yellow-500 mb-4"></i>
                    <h3 class="text-xl font-bold mb-2">Système de Notes</h3>
                    <p class="text-gray-400">Notez et critiquez vos jeux préférés</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 