<?php
session_start();
require_once 'connexion.php';
require_once 'GameClass.php';
require_once 'UserClass.php';

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

$_SESSION['added'] = false;
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

    
    </style>
</head>

<body class="bg-[#0F172A] text-gray-100">
<?php include 'header.php'?>

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
                                <a href="/Briefs/Brief-10/GameVault/views/game/game_details.php?id=<?= $gameItem['jeu_id'] ?>"
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
                                        <i class="fas fa-star <?= $i < $game->avgRate($gameItem['jeu_id']) ? 'text-[#FFD700]' : 'text-gray-600' ?> text-sm"></i>
                                    <?php endfor; ?>
                                </div>
                                <span class="ml-2 text-sm text-gray-400"><?= number_format($game->avgRate($gameItem['jeu_id']), 1) ?></span>
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

  
    <div class="bg-[#1e1b4b]/30 backdrop-blur-sm border-t border-b border-zinc-700/30">
        <div class="max-w-7xl mx-auto px-6 py-20">
            <h2 class="text-3xl font-bold text-center mb-12">Nos <span class="gradient-text">Fonctionnalités</span></h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <div class="bg-[#1e1b4b]/40 p-6 rounded-lg backdrop-blur-sm border border-zinc-700/30 hover:border-indigo-500/50 transition-colors group">
                    <div class="bg-indigo-600/20 p-3 rounded-lg w-12 h-12 flex items-center justify-center mb-4 group-hover:bg-indigo-600/30 transition-colors">
                        <i class="fas fa-folder text-indigo-400"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Gérez votre collection</h3>
                    <p class="text-zinc-400">Organisez et suivez votre bibliothèque de jeux en un seul endroit.</p>
                </div>

                <div class="bg-[#1e1b4b]/40 p-6 rounded-lg backdrop-blur-sm border border-zinc-700/30 hover:border-indigo-500/50 transition-colors group">
                    <div class="bg-indigo-600/20 p-3 rounded-lg w-12 h-12 flex items-center justify-center mb-4 group-hover:bg-indigo-600/30 transition-colors">
                        <i class="fas fa-users text-indigo-400"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Rejoignez la communauté</h3>
                    <p class="text-zinc-400">Partagez vos expériences et découvrez celles des autres joueurs.</p>
                </div>

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

    <?php include 'footer.php'?>
</body>

</html>