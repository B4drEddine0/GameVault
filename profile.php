<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameVault - Profil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .gradient-text {
            background: linear-gradient(to right, #818cf8, #6366f1);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .glow-effect {
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.3);
        }
        body {
            background: linear-gradient(to bottom, #1e1b4b, #111827);
            min-height: 100vh;
        }
    </style>
</head>
<body class="text-zinc-100">
    <!-- Navigation -->
    <nav class="fixed w-full z-10 bg-zinc-900/30 backdrop-blur-sm border-b border-zinc-700/30">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold">Game<span class="gradient-text">Vault</span></h1>
                    <div class="ml-10 flex items-center space-x-4">
                        <a href="index.php" class="text-zinc-400 hover:text-white px-3 py-2">Accueil</a>
                        <a href="#" class="text-zinc-400 hover:text-white px-3 py-2">Jeux</a>
                        <a href="#" class="text-zinc-400 hover:text-white px-3 py-2">Chat</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="pt-16 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 py-8">
            <!-- Profile Header -->
            <div class="bg-zinc-800/30 backdrop-blur-sm rounded-lg p-6 mb-6 border border-zinc-700/30">
                <div class="flex items-start space-x-6">
                    <div class="relative">
                        <img src="https://via.placeholder.com/150" alt="Profile" class="w-32 h-32 rounded-full">
                        <button class="absolute bottom-0 right-0 bg-indigo-600/90 p-2 rounded-full hover:bg-indigo-500 glow-effect">
                            <i class="fas fa-camera"></i>
                        </button>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <div>
                                <h2 class="text-2xl font-bold">John <span class="gradient-text">Doe</span></h2>
                                <p class="text-zinc-400">@johndoe</p>
                            </div>
                            <button class="bg-indigo-600/90 px-4 py-2 rounded-lg hover:bg-indigo-500 glow-effect">
                                Éditer le profil
                            </button>
                        </div>
                        <p class="mt-4 text-zinc-300">Bio: Passionné de jeux vidéo et de nouvelles technologies.</p>
                    </div>
                </div>
            </div>

            <!-- Profile Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Personal Information -->
                <div class="bg-zinc-800/30 backdrop-blur-sm rounded-lg p-6 border border-zinc-700/30">
                    <h3 class="text-xl font-bold mb-4">Informations <span class="gradient-text">Personnelles</span></h3>
                    <form class="space-y-4">
                        <div>
                            <label class="block text-gray-300 mb-2">Prénom</label>
                            <input type="text" value="John" 
                                   class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600">
                        </div>
                        <div>
                            <label class="block text-gray-300 mb-2">Nom</label>
                            <input type="text" value="Doe" 
                                   class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600">
                        </div>
                        <div>
                            <label class="block text-gray-300 mb-2">Email</label>
                            <input type="email" value="john@example.com" 
                                   class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600">
                        </div>
                        <div>
                            <label class="block text-gray-300 mb-2">Bio</label>
                            <textarea class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600 h-32">Passionné de jeux vidéo et de nouvelles technologies.</textarea>
                        </div>
                    </form>
                </div>

                <!-- Gaming Stats -->
                <div class="space-y-6">
                    <div class="bg-zinc-800/30 backdrop-blur-sm rounded-lg p-6 border border-zinc-700/30">
                        <h3 class="text-xl font-bold mb-4">Statistiques de <span class="gradient-text">Jeu</span></h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-center">
                                <p class="text-3xl font-bold text-purple-500">42</p>
                                <p class="text-gray-400">Jeux possédés</p>
                            </div>
                            <div class="text-center">
                                <p class="text-3xl font-bold text-purple-500">128</p>
                                <p class="text-gray-400">Heures jouées</p>
                            </div>
                            <div class="text-center">
                                <p class="text-3xl font-bold text-purple-500">15</p>
                                <p class="text-gray-400">Jeux terminés</p>
                            </div>
                            <div class="text-center">
                                <p class="text-3xl font-bold text-purple-500">4.5</p>
                                <p class="text-gray-400">Note moyenne</p>
                            </div>
                        </div>
                    </div>

                    <!-- Security Settings -->
                    <div class="bg-zinc-800/30 backdrop-blur-sm rounded-lg p-6 border border-zinc-700/30">
                        <h3 class="text-xl font-bold mb-4"><span class="gradient-text">Sécurité</span></h3>
                        <form class="space-y-4">
                            <div>
                                <label class="block text-gray-300 mb-2">Ancien mot de passe</label>
                                <input type="password" 
                                       class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600">
                            </div>
                            <div>
                                <label class="block text-gray-300 mb-2">Nouveau mot de passe</label>
                                <input type="password" 
                                       class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600">
                            </div>
                            <div>
                                <label class="block text-gray-300 mb-2">Confirmer le mot de passe</label>
                                <input type="password" 
                                       class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600">
                            </div>
                            <button type="submit" class="w-full bg-purple-600 px-4 py-2 rounded-lg hover:bg-purple-700">
                                Mettre à jour le mot de passe
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 