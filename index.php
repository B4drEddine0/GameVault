<?php
session_start();
include('connexion.php');
require_once 'GameClass.php';


$dbConnection = new DbConnection();
$conn = $dbConnection->getConnection();
if (!isset($_SESSION['username'])) {
    header('Location: signin.php');
    exit;
}

$username = $_SESSION['username'];


$userId = $_SESSION['user_id'];
$query = "SELECT image FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->execute([$username]);
$user = $stmt->fetch();






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
        body {
            background: linear-gradient(to bottom, #1e1b4b, #111827);
            min-height: 100vh;
        }

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
            0% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-10px) rotate(2deg);
            }

            100% {
                transform: translateY(0px) rotate(0deg);
            }
        }

        .float-animation {
            animation: float 4s ease-in-out infinite;
        }

        @keyframes glow {
            0% {
                filter: drop-shadow(0 0 2px rgba(99, 102, 241, 0.2));
            }

            50% {
                filter: drop-shadow(0 0 8px rgba(99, 102, 241, 0.4));
            }

            100% {
                filter: drop-shadow(0 0 2px rgba(99, 102, 241, 0.2));
            }
        }

        svg.float-animation {
            filter: drop-shadow(0 0 4px rgba(99, 102, 241, 0.3));
            animation: float 4s ease-in-out infinite, glow 2s ease-in-out infinite;
        }
    </style>
</head>

<body class="bg-[#0F172A] text-gray-100">
    <!-- Header -->
    <nav class="fixed w-full z-10 bg-zinc-900/30 backdrop-blur-sm border-b border-zinc-700/30">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <h1 class="text-2xl font-bold">Game<span class="gradient-text">Vault</span></h1>
                    <div class="ml-10 flex items-center space-x-4">
                        <a href="#" class="text-gray-300 hover:text-white px-3 py-2">Accueil</a>
                        <a href="#" class="text-gray-300 hover:text-white px-3 py-2">Jeux</a>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-300 hover:text-white px-3 py-2">Chat</a>
                            <?php if (isset($_SESSION['username'])): ?>
                                <a href="bibliotheque.php" class="text-gray-300 hover:text-white px-3 py-2">Ma Collection</a>
                                <a href="historique.php" class="text-gray-300 hover:text-white px-3 py-2">Mon Historique</a>
                                <a href="#" class="text-gray-300 hover:text-white px-3 py-2">Mes Favoris</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="flex items-center">
                    <?php if (isset($_SESSION['username'])): ?>
                        <div class="flex items-center space-x-4">
                            <img src="<?php echo htmlspecialchars($user['image'] ?? 'images/profil.webp'); ?>"
                                alt=""
                                class="w-10 h-10 rounded-full cursor-pointer"
                                onclick="window.location.href='profil.php';">
                            <span class="text-white"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                            <button
                                class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg"
                                onclick="window.location.href='logout.php';">
                                Déconnexion
                            </button>
                        </div>
                    <?php else: ?>
                        <button
                            class="bg-purple-600 hover:bg-purple-700 px-4 py-2 rounded-lg mr-4"
                            onclick="window.location.href='signin.php';">
                            Connexion
                        </button>
                        <button
                            class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg"
                            onclick="window.location.href='signup.php';">
                            Inscription
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative min-h-screen flex items-center">
        <div class="absolute inset-0 bg-[#1e1b4b]/50"></div>
        <div class="relative max-w-7xl mx-auto px-6 py-32">
            <h1 class="text-4xl md:text-6xl font-bold mb-4">
                Bienvenue sur <span class="gradient-text">GameVault</span>
            </h1>
            <p class="text-xl text-zinc-300 mb-8">
                Votre <span class="gradient-text">Collection</span><br>
                Votre <span class="gradient-text">Univers</span>
            </p>
            <!-- Search Bar -->
            <div class="max-w-2xl">
                <div class="relative">
                    <input type="text"
                        placeholder="Rechercher un jeu..."
                        class="w-full px-6 py-4 bg-zinc-800/50 border border-zinc-700/30 rounded-lg text-white backdrop-blur-sm focus:outline-none focus:border-indigo-500 transition-colors">
                    <button class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-indigo-600/90 hover:bg-indigo-500 p-2 rounded-lg transition-colors glow-effect">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-[#1e1b4b]/10 backdrop-blur-sm border-t border-b border-zinc-700/30">
        <div class="max-w-7xl mx-auto px-6 py-16">
            <h2 class="text-3xl font-bold mb-8">Jeux <span class="gradient-text">Populaires</span></h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php
                $game = new Game();
                $games = $game->getAllGames();

                foreach ($games as $gameItem):
                    $imageUrl = !empty($gameItem['image']) ? $gameItem['image'] : 'images/default-game.jpg';
                ?>
                    <div class="game-card bg-zinc-800 rounded-lg overflow-hidden">
                        <div class="relative group">
                            <img src="<?= htmlspecialchars($imageUrl) ?>"
                                alt="<?= htmlspecialchars($gameItem['title']) ?>"
                                class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-120"
                                onerror="this.src='assets/images/default-game.jpg'">
                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <a href="game_details.php?id=<?= $gameItem['jeu_id'] ?>"
                                    class="px-4 py-2 bg-indigo-600 rounded-md text-white transform -translate-y-2 group-hover:translate-y-0 transition-all">
                                    Voir détails
                                </a>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="font-bold text-lg mb-2"><?= htmlspecialchars($gameItem['title']) ?></h3>
                            <div class="flex items-center mb-3">
                                <div class="flex items-center text-[#FFD700]">
                                    <?php for ($i = 0; $i < 5; $i++): ?>
                                        <i class="fas fa-star <?= $i < $gameItem['rating'] ? 'text-[#FFD700]' : 'text-gray-600' ?> text-sm"></i>
                                    <?php endfor; ?>
                                </div>
                                <span class="ml-2 text-sm text-gray-400"><?= number_format($gameItem['rating'], 1) ?></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-400"><?= htmlspecialchars($gameItem['type']) ?></span>
                                <button class="text-[#4ECDC4] hover:text-white transition-colors">
                                    <i class="far fa-bookmark"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php
                endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Functionality Section -->
    <div class="bg-[#1e1b4b]/30 backdrop-blur-sm border-t border-b border-zinc-700/30">
        <div class="max-w-7xl mx-auto px-6 py-20">
            <h2 class="text-3xl font-bold text-center mb-12">Nos <span class="gradient-text">Fonctionnalités</span></h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Collection Card -->
                <div class="bg-[#1e1b4b]/40 p-6 rounded-lg backdrop-blur-sm border border-zinc-700/30 hover:border-indigo-500/50 transition-colors group">
                    <div class="bg-indigo-600/20 p-3 rounded-lg w-12 h-12 flex items-center justify-center mb-4 group-hover:bg-indigo-600/30 transition-colors">
                        <i class="fas fa-folder text-indigo-400"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Gérez votre collection</h3>
                    <p class="text-zinc-400">Organisez et suivez votre bibliothèque de jeux en un seul endroit.</p>
                </div>

                <!-- Community Card -->
                <div class="bg-[#1e1b4b]/40 p-6 rounded-lg backdrop-blur-sm border border-zinc-700/30 hover:border-indigo-500/50 transition-colors group">
                    <div class="bg-indigo-600/20 p-3 rounded-lg w-12 h-12 flex items-center justify-center mb-4 group-hover:bg-indigo-600/30 transition-colors">
                        <i class="fas fa-users text-indigo-400"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Rejoignez la communauté</h3>
                    <p class="text-zinc-400">Partagez vos expériences et découvrez celles des autres joueurs.</p>
                </div>

                <!-- Stats Card -->
                <div class="bg-[#1e1b4b]/40 p-6 rounded-lg backdrop-blur-sm border border-zinc-700/30 hover:border-indigo-500/50 transition-colors group">
                    <div class="bg-indigo-600/20 p-3 rounded-lg w-12 h-12 flex items-center justify-center mb-4 group-hover:bg-indigo-600/30 transition-colors">
                        <i class="fas fa-chart-bar text-indigo-400"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Suivez vos statistiques</h3>
                    <p class="text-zinc-400">Visualisez votre temps de jeu et vos accomplissements.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Gaming Footer -->
    <footer class="bg-[#1e1b4b]/40 backdrop-blur-sm border-t border-zinc-700/30">
        <div class="max-w-7xl mx-auto px-6 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Logo Section -->
                <div class="col-span-1">
                    <h2 class="text-2xl font-bold mb-4">Game<span class="gradient-text">Vault</span></h2>
                    <p class="text-zinc-400">Votre univers gaming, simplifié.</p>
                </div>

                <!-- Quick Links -->
                <div class="col-span-1">
                    <h3 class="text-lg font-semibold mb-4">Navigation</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-zinc-400 hover:text-white transition-colors">Découvrir</a></li>
                        <li><a href="#" class="text-zinc-400 hover:text-white transition-colors">Bibliothèque</a></li>
                        <li><a href="#" class="text-zinc-400 hover:text-white transition-colors">Communauté</a></li>
                    </ul>
                </div>

                <!-- Community -->
                <div class="col-span-1">
                    <h3 class="text-lg font-semibold mb-4">Communauté</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-zinc-400 hover:text-white transition-colors">Discord</a></li>
                        <li><a href="#" class="text-zinc-400 hover:text-white transition-colors">Forum</a></li>
                        <li><a href="#" class="text-zinc-400 hover:text-white transition-colors">Blog</a></li>
                    </ul>
                </div>

                <!-- Social Links -->
                <div class="col-span-1">
                    <h3 class="text-lg font-semibold mb-4">Suivez-nous</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="bg-indigo-600/20 p-2 rounded-lg hover:bg-indigo-600/30 transition-colors">
                            <i class="fab fa-discord text-zinc-400 hover:text-white"></i>
                        </a>
                        <a href="#" class="bg-indigo-600/20 p-2 rounded-lg hover:bg-indigo-600/30 transition-colors">
                            <i class="fab fa-twitter text-zinc-400 hover:text-white"></i>
                        </a>
                        <a href="#" class="bg-indigo-600/20 p-2 rounded-lg hover:bg-indigo-600/30 transition-colors">
                            <i class="fab fa-twitch text-zinc-400 hover:text-white"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-zinc-700/30 mt-8 pt-8 text-center text-zinc-400">
                <p>&copy; 2024 GameVault. Tous droits réservés.</p>
            </div>
        </div>
    </footer>
</body>

</html>