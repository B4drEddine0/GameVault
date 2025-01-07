<?php
session_start();
include('connexion.php');
require_once 'GameClass.php';
require_once 'bibliotheClass.php';


$dbConnection = new DbConnection();
$conn = $dbConnection->getConnection();

// Récupérer l'ID du jeu depuis l'URL
$jeu_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$game = new Game();
$game->setJeu_id($jeu_id);
$gameDetails = $game->getSelectedGame();

if (!$gameDetails) {
    header('Location: index.php');
    exit();
}

$_SESSION['game_id'] = $jeu_id;

// Vérifier si l'enregistrement existe déjà
$checkQuery = "SELECT COUNT(*) FROM historique WHERE users_id = :users_id AND jeu_id = :jeu_id";
$checkStmt = $conn->prepare($checkQuery);
$checkStmt->bindParam(':users_id', $_SESSION['user_id']);
$checkStmt->bindParam(':jeu_id', $_SESSION['game_id']);
$checkStmt->execute();

$exists = $checkStmt->fetchColumn();

// ajout dans l'historique

if ($exists == 0) {
    // Insérer uniquement si aucun enregistrement trouvé
    $query = "INSERT INTO historique (users_id, jeu_id) VALUES (:users_id, :jeu_id)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':users_id', $_SESSION['user_id']);
    $stmt->bindParam(':jeu_id', $_SESSION['game_id']);
    $stmt->execute();
}

// ajout dans la collection


if(isset($_POST['addToCollection'])){
    $query = "INSERT INTO bibliotheque (users_id, jeu_id) VALUES (:users_id, :jeu_id)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':users_id', $_SESSION['user_id']);
    $stmt->bindParam(':jeu_id', $_SESSION['game_id']);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($gameDetails['title']) ?> - GameVault</title>
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
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <a href="index.php" class="text-2xl font-bold">Game<span class="gradient-text">Vault</span></a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Game Details Section -->
    <div class="pt-20 min-h-screen">
        <div class="max-w-7xl mx-auto px-6 py-12">
            <div class="grid md:grid-cols-2 gap-12">
                <!-- Image Section -->
                <div class="relative group">
                    <div class="aspect-w-16 aspect-h-9 rounded-lg overflow-hidden bg-zinc-800/30 backdrop-blur-sm border border-zinc-700/30">
                        <img src="<?= !empty($gameDetails['image']) ? htmlspecialchars($gameDetails['image']) : 'images/default-game.jpg' ?>" 
                             alt="<?= htmlspecialchars($gameDetails['title']) ?>"
                             class="w-full h-full object-cover">
                    </div>
                    <div class="flex mt-4 space-x-2">
                        <!-- Image 1 -->
                        <div class="w-1/3 rounded-lg overflow-hidden">
                            <img src="<?= !empty($gameDetails['image2']) ? htmlspecialchars($gameDetails['image2']) : 'images/default-game.jpg' ?>" 
                                alt="Image 2" 
                                class="w-full h-32 object-cover">
                        </div>

                        <!-- Image 2 -->
                        <div class="w-1/3 rounded-lg overflow-hidden">
                            <img src="<?= !empty($gameDetails['image3']) ? htmlspecialchars($gameDetails['image3']) : 'images/default-game.jpg' ?>" 
                                alt="Image 3" 
                                class="w-full h-32 object-cover">
                        </div>

                        <!-- Image 3 -->
                        <div class="w-1/3 rounded-lg overflow-hidden">
                            <img src="<?= !empty($gameDetails['image4']) ? htmlspecialchars($gameDetails['image4']) : 'images/default-game.jpg' ?>" 
                                alt="Image 4" 
                                class="w-full h-32 object-cover">
                        </div>
                    </div>
                </div>

                <!-- Details Section -->
                <div class="space-y-6 bg-zinc-800/30 backdrop-blur-sm p-6 rounded-lg border border-zinc-700/30">
                    <h1 class="text-4xl font-bold">
                        <?= htmlspecialchars($gameDetails['title']) ?>
                    </h1>

                    <!-- Rating -->
                    <div class="flex items-center space-x-2">
                        <div class="flex items-center">
                            <?php for ($i = 0; $i < 5; $i++): ?>
                                <i class="fas fa-star <?= $i < $gameDetails['rating'] ? 'text-amber-400' : 'text-zinc-600' ?>"></i>
                            <?php endfor; ?>
                        </div>
                        <span class="text-zinc-400">(<?= number_format($gameDetails['rating'], 1) ?>)</span>
                    </div>

                    <!-- Type & Release Date -->
                    <div class="flex space-x-4 text-zinc-400">
                        <div class="flex items-center">
                            <i class="fas fa-gamepad mr-2"></i>
                            <?= htmlspecialchars($gameDetails['type']) ?>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-calendar mr-2"></i>
                            <?= htmlspecialchars($gameDetails['date_sortie']) ?>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="prose prose-invert">
                        <h2 class="text-xl font-bold mb-2">Description</h2>
                        <p class="text-zinc-400 leading-relaxed">
                            <?= nl2br(htmlspecialchars($gameDetails['description'])) ?>
                        </p>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-2 gap-4 py-6">
                        <div class="bg-zinc-800 p-4 rounded-lg">
                            <div class="text-zinc-400 text-sm">Nombre d'utilisateurs</div>
                            <div class="text-2xl font-bold"><?= number_format($gameDetails['nb_users']) ?></div>
                        </div>
                        <div class="bg-zinc-800 p-4 rounded-lg">
                            <div class="text-zinc-400 text-sm">Temps de jeu moyen</div>
                            <div class="text-2xl font-bold"><?= $gameDetails['temps_jeu'] ?> heures</div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex space-x-4">
                        <form action="" method="POST">
                            <button type="submit" name="addToCollection" class="px-6 py-3 bg-indigo-600/90 hover:bg-indigo-500 rounded-lg transition-colors glow-effect">
                                <i class="fas fa-bookmark mr-2"></i>
                                Ajouter à ma collection
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Similar Games Section -->
            <div class="mt-20">
                <h2 class="text-2xl font-bold mb-8">Jeux <span class="gradient-text">similaires</span></h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Similar games will be added here -->
                </div>
            </div>
        </div>
    </div>
</body>

</html>