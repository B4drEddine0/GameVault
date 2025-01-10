<?php
session_start();
include('connexion.php');
require_once 'GameClass.php';
require_once 'classFavoris.php';

$dbConnection = new DbConnection();
$conn = $dbConnection->getConnection();

if (!isset($_SESSION['username'])) {
    header('Location: signin.php');
    exit;
}

$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    header('Location: signin.php');
    exit;
}

$favoris = new Favoris($conn);
$favorisData = $favoris->GetFavoris($userId);

$query = "SELECT image FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->execute([$_SESSION['username']]);
$user = $stmt->fetch();

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameVault - Favoris</title>
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

        .float-animation {
            animation: float 4s ease-in-out infinite;
        }

        svg.float-animation {
            animation: glow 2s ease-in-out infinite;
        }
    </style>
</head>

<body class="text-zinc-100">
    <!-- Navigation -->
    <?php include 'header.php'?>

    <div class="pt-20 min-h-screen">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold">Votre <span class="gradient-text">Favoris</span></h2>
            </div>

            <div class="space-y-6">
                <?php if (!empty($favorisData)): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($favorisData as $game): ?>
                            <div class="bg-[#1e1b4b]/30 rounded-lg backdrop-blur-sm border border-zinc-700/30 overflow-hidden group flex flex-col">
                                <div class="relative">
                                    <img src="<?= htmlspecialchars($game['image']); ?>" class="w-full h-48 object-cover">
                                    <!-- Icône de favori rouge et agrandie, placée dans un espace entre l'image et le bord supérieur -->
                                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <a href="game_details.php?id=<?= $gameItem['jeu_id'] ?>"
                                            class="px-4 py-2 bg-indigo-600 rounded-md text-white transform -translate-y-2 group-hover:translate-y-0 transition-all">
                                            Voir détails
                                        </a>
                                    </div>
                                </div>
                                <div class="p-4 flex-grow pb-2"> <!-- Réduction du padding bottom pour minimiser l'espace -->
                                    <h4 class="font-bold mb-1"><?= htmlspecialchars($game['title']); ?></h4>
                                    <p class="text-zinc-400 text-sm mb-2"><?= htmlspecialchars($game['type']); ?></p> <!-- Réduction du margin bottom -->
                                </div>
                                <div class="flex justify-between items-center px-4">
                                    <form method="POST" action="" class="inline-block">
                                        <input type="hidden" name="game_id" value="<?= $game['jeu_id']; ?>">
                                        <button type="submit" name="delete_game" class="text-red-400 hover:text-red-600 transition-colors">
                                            <i class="fas fa-heart"></i>
                                        </button>
                                    </form>
                                </div>

                            </div>
                        <?php endforeach; ?>
                    </div>



                <?php else: ?>
                    <p>Aucune donnée trouvée dans votre favoris.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php include 'footer.php'?>
</body>

</html>