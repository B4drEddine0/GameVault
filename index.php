<?php
require_once 'GameClass.php';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameVault</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .game-card {
            transition: transform 0.3s ease;
        }
        .game-card:hover {
            transform: translateY(-10px);
        }
        .gradient-text {
            background: linear-gradient(45deg, #FF6B6B, #4ECDC4);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .game-card img {
            backface-visibility: hidden;
        }

        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(2deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }

        .float-animation {
            animation: float 4s ease-in-out infinite;
        }

        @keyframes glow {
            0% { filter: drop-shadow(0 0 2px rgba(99, 102, 241, 0.2)); }
            50% { filter: drop-shadow(0 0 8px rgba(99, 102, 241, 0.4)); }
            100% { filter: drop-shadow(0 0 2px rgba(99, 102, 241, 0.2)); }
        }

        svg.float-animation {
            filter: drop-shadow(0 0 4px rgba(99, 102, 241, 0.3));
            animation: float 4s ease-in-out infinite, glow 2s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-[#0F172A] text-gray-100">
    <!-- Navigation -->
    <nav class="fixed w-full z-10 backdrop-blur-md bg-[#0F172A]/80 border-b border-gray-800">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between h-20">
                <div class="flex items-center space-x-8">
                    <h1 class="text-2xl font-bold gradient-text">GameVault</h1>
                    <div class="hidden md:flex space-x-6">
                        <a href="#" class="text-gray-300 hover:text-[#4ECDC4] transition-colors">Accueil</a>
                        <a href="#" class="text-gray-300 hover:text-[#4ECDC4] transition-colors">Découvrir</a>
                        <a href="#" class="text-gray-300 hover:text-[#4ECDC4] transition-colors">Communauté</a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="signin.php" class="px-4 py-2 rounded-full border border-[#4ECDC4] text-[#4ECDC4] hover:bg-[#4ECDC4] hover:text-white transition-colors">
                        Connexion
                    </a>
                    <a href="signup.php" class="px-4 py-2 rounded-full bg-gradient-to-r from-[#FF6B6B] to-[#4ECDC4] hover:opacity-90 transition-opacity">
                        Inscription
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="pt-20 min-h-screen flex items-center relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('path/to/gaming-pattern.png')] opacity-5"></div>
        <div class="max-w-7xl mx-auto px-6 py-20 relative z-10">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-5xl font-bold mb-6 leading-tight">
                        Votre <span class="gradient-text">Collection</span><br>
                        Votre <span class="gradient-text">Univers</span>
                    </h2>
                    <p class="text-gray-400 text-lg mb-8">
                        Explorez, gérez et partagez votre passion pour les jeux vidéo dans un espace unique et personnalisé.
                    </p>
                    <div class="flex space-x-4">
                        <a href="signup.php" class="px-8 py-3 rounded-full bg-gradient-to-r from-[#FF6B6B] to-[#4ECDC4] hover:opacity-90 transition-opacity inline-flex items-center">
                            Commencer <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                        <a href="#games" class="px-8 py-3 rounded-full border border-gray-700 hover:border-[#4ECDC4] transition-colors">
                            Explorer
                        </a>
                    </div>
                </div>
                <div class="hidden md:block relative">
                    <div class="absolute inset-0 bg-indigo-500/10 blur-3xl rounded-full"></div>
                    <svg class="w-full h-auto float-animation" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <filter id="glow">
                                <feGaussianBlur stdDeviation="2" result="coloredBlur"/>
                                <feMerge>
                                    <feMergeNode in="coloredBlur"/>
                                    <feMergeNode in="SourceGraphic"/>
                                </feMerge>
                            </filter>
                        </defs>
                        
                        <g fill="none" stroke="currentColor" stroke-width="2" class="text-indigo-400" filter="url(#glow)">
                            <!-- Corps principal -->
                            <path d="M50,70 
                                     C50,70 60,60 100,60
                                     C140,60 150,70 150,70
                                     L160,100
                                     C160,130 130,140 100,140
                                     C70,140 40,130 40,100
                                     L50,70"
                                  class="text-indigo-400">
                                <animate attributeName="stroke-dasharray" 
                                         values="1,400;400,1;1,400" 
                                         dur="3s" 
                                         repeatCount="indefinite"/>
                            </path>

                            <!-- Touchpad -->
                            <rect x="75" y="70" width="50" height="25" rx="5"/>

                            <!-- Joysticks (maintenant alignés) -->
                            <circle cx="75" cy="115" r="8"/>
                            <circle cx="125" cy="115" r="8"/>

                            <!-- Boutons -->
                            <circle cx="140" cy="100" r="4"/>
                            <circle cx="147" cy="93" r="4"/>
                            <circle cx="147" cy="107" r="4"/>
                            <circle cx="154" cy="100" r="4"/>

                            <!-- D-pad -->
                            <path d="M53,100 L67,100 M60,93 L60,107"/>
                        </g>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Games Section -->
    <div id="games" class="py-20 relative">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-center mb-12">
                <h2 class="text-3xl font-bold">Jeux Populaires</h2>
                <a href="#" class="text-[#4ECDC4] hover:underline">Voir tout</a>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php
                $game = new Game();
                $games = $game->getAllGames();

                foreach($games as $gameItem): 
                        $imageUrl = !empty($gameItem['image']) ? $gameItem['image'] : 'images/default-game.jpg';
                        ?>
                        <div class="game-card bg-zinc-800 rounded-lg overflow-hidden">
                            <div class="relative group">
                                <img src="<?= htmlspecialchars($imageUrl) ?>" 
                                     alt="<?= htmlspecialchars($gameItem['title']) ?>" 
                                     class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-120"
                                     onerror="this.src='assets/images/default-game.jpg'">
                                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <button class="px-4 py-2 bg-indigo-600 rounded-md text-white transform -translate-y-2 group-hover:translate-y-0 transition-all">
                                        Voir détails
                                    </button>
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="font-bold text-lg mb-2"><?= htmlspecialchars($gameItem['title']) ?></h3>
                                <div class="flex items-center mb-3">
                                    <div class="flex items-center text-[#FFD700]">
                                        <?php for($i = 0; $i < 5; $i++): ?>
                                            <i class="fas fa-star <?= $i < $gameItem['rating'] ? 'text-[#FFD700]' : 'text-gray-600' ?> text-sm"></i>
                                        <?php endfor; ?>
                                    </div>
                                    <span class="ml-2 text-sm text-gray-400"><?= number_format($gameItem['rating'], 1) ?></span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-400"><?= htmlspecialchars($gameItem['type']) ?></span>
                                    <button class="text-[#4ECDC4] hover:text-white transition-colors">
                                        <i class="fas fa-bookmark"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                <?php 
                endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-20 bg-[#1E293B]">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-16">Fonctionnalités</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="group">
                    <div class="bg-[#0F172A] p-8 rounded-xl relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-[#FF6B6B]/10 to-[#4ECDC4]/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <i class="fas fa-gamepad text-3xl text-[#FF6B6B] mb-6"></i>
                        <h3 class="text-xl font-bold mb-4">Collection Intelligente</h3>
                        <p class="text-gray-400">Organisez votre bibliothèque de jeux avec des outils avancés et intuitifs.</p>
                    </div>
                </div>
                <div class="group">
                    <div class="bg-[#0F172A] p-8 rounded-xl relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-[#FF6B6B]/10 to-[#4ECDC4]/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <i class="fas fa-users text-3xl text-[#4ECDC4] mb-6"></i>
                        <h3 class="text-xl font-bold mb-4">Communauté Active</h3>
                        <p class="text-gray-400">Échangez avec des passionnés et partagez vos expériences de jeu.</p>
                    </div>
                </div>
                <div class="group">
                    <div class="bg-[#0F172A] p-8 rounded-xl relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-[#FF6B6B]/10 to-[#4ECDC4]/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <i class="fas fa-chart-line text-3xl text-[#FFD700] mb-6"></i>
                        <h3 class="text-xl font-bold mb-4">Suivi Personnalisé</h3>
                        <p class="text-gray-400">Suivez vos statistiques et votre progression en temps réel.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
