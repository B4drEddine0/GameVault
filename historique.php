<?php
session_start();
include('connexion.php');
require_once 'GameClass.php';
require_once 'classHistorique.php';

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

$historique = new Historique($conn);
$historiqueData = $historique->GetHistorique($userId);



$today = date('Y-m-d');
$yesterday = date('Y-m-d', strtotime('-1 day'));
$thisWeek = date('Y-m-d', strtotime('-7 days'));

$sections = [
    "Aujourd'hui" => [],
    "Hier" => [],
    "Cette Semaine" => []
];

if (!empty($historiqueData)) {
    foreach ($historiqueData as $item) {
        $addAtDate = date('Y-m-d', strtotime($item['add_at']));
        if ($addAtDate === $today) {
            $sections["Aujourd'hui"][] = $item;
        } elseif ($addAtDate === $yesterday) {
            $sections["Hier"][] = $item;
        } elseif ($addAtDate >= $thisWeek) {
            $sections["Cette Semaine"][] = $item;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_history'])) {
    $historique->DeleteHistory($userId);
    header('Location: historique.php'); // Recharge la page pour actualiser l'affichage.
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameVault - Historique</title>
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
    <nav class="fixed w-full z-10 bg-zinc-900/30 backdrop-blur-sm border-b border-zinc-700/30">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <h1 class="text-2xl font-bold">Game<span class="gradient-text">Vault</span></h1>
                    <div class="ml-10 flex items-center space-x-4">
                        <a href="#" class="text-gray-300 hover:text-white px-3 py-2">Accueil</a>
                        <a href="#" class="text-gray-300 hover:text-white px-3 py-2">Jeux</a>
                        <a href="#" class="text-gray-300 hover:text-white px-3 py-2">Chat</a>
                        <a href="#" class="text-gray-300 hover:text-white px-3 py-2">Ma Collection</a>
                        <a href="historique.php" class="text-gray-300 hover:text-white px-3 py-2">Mon Historique</a>
                        <a href="#" class="text-gray-300 hover:text-white px-3 py-2">Mes Favoris</a>
                    </div>
                </div>
                <div class="flex items-center">
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
                </div>
            </div>
        </div>
    </nav>

    <div class="pt-20 min-h-screen">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold">Votre <span class="gradient-text">Historique</span></h2>
                <form method="POST" action="" onsubmit="return confirm('Voulez-vous vraiment effacer tout l’historique ?');">
                    <button name="delete_history" class="text-zinc-400 hover:text-white transition-colors">
                        <i class="fas fa-trash-alt"></i> Effacer l'historique
                    </button>
                </form>
            </div>

            <div class="space-y-6">
                <?php foreach ($sections as $title => $games): ?>
                    <?php if (!empty($games)): ?>
                        <div class="border-l-2 border-indigo-500/30 pl-6 ml-3">
                            <h3 class="text-lg font-semibold mb-4 text-zinc-400"><?php echo $title; ?></h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <?php foreach ($games as $game): ?>
                                    <div class="bg-[#1e1b4b]/30 rounded-lg backdrop-blur-sm border border-zinc-700/30 overflow-hidden group">
                                        <div class="relative">
                                            <img src="<?= htmlspecialchars($game['image']); ?>" class="w-full h-48 object-cover">
                                            <div class="absolute top-2 right-2">
                                                <span class="bg-indigo-600/90 px-2 py-1 rounded text-sm">
                                                    <i class="fas fa-clock mr-1"></i> <?= date('H:i', strtotime($game['add_at'])); ?>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="p-4">
                                            <h4 class="font-bold mb-1"><?= htmlspecialchars($game['title']); ?></h4>
                                            <p class="text-zinc-400 text-sm mb-3"><?= htmlspecialchars($game['type']); ?></p>
                                            <div class="flex justify-between items-center">
                                                <button class="text-indigo-400 hover:text-indigo-300 transition-colors">
                                                    <i class="fas fa-external-link-alt"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>

                <?php if (empty($historiqueData)): ?>
                    <div class="text-center py-20">
                        <div class="bg-[#1e1b4b]/30 rounded-lg backdrop-blur-sm border border-zinc-700/30 p-8 max-w-md mx-auto">
                            <i class="fas fa-history text-4xl text-indigo-400 mb-4"></i>
                            <h3 class="text-xl font-bold mb-2">Aucun historique</h3>
                            <p class="text-zinc-400">Commencez à explorer des jeux pour voir votre historique apparaître ici.</p>
                            <a href="index.php" class="inline-block mt-4 px-6 py-2 bg-indigo-600/90 hover:bg-indigo-500 rounded-lg transition-colors">
                                Découvrir des jeux
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>