<?php

session_start();
include('connexion.php');
require_once 'GameClass.php';
require_once 'bibliotheClass.php';
require_once 'classFavoris.php';

$dbConnection = new DbConnection();
$conn = $dbConnection->getConnection();

$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    header('Location: signin.php');
    exit;
}
$favoris = new Favoris($conn);
$bibliotheque = new Bibliotheque($conn);
$bibliothequeData = $bibliotheque->GetBibliotheque($userId); 

?><!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameVault - Bibliothèque</title>
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
    <?php include 'header.php'?>

    <div class="pt-20 min-h-screen">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold">Votre <span class="gradient-text">Bibliothèque</span></h2>
            </div>

            <div class="space-y-6">
                <?php if (!empty($bibliothequeData)): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($bibliothequeData as $game): ?>
                            <div class="bg-[#1e1b4b]/30 rounded-lg backdrop-blur-sm border border-zinc-700/30 overflow-hidden group flex flex-col">
                                <div class="relative">
                                    <img src="<?= htmlspecialchars($game['image']); ?>" class="w-full h-48 object-cover">
                                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <a href="game_details.php?id=<?= $gameItem['jeu_id'] ?>"
                                            class="px-4 py-2 bg-indigo-600 rounded-md text-white transform -translate-y-2 group-hover:translate-y-0 transition-all">
                                            Voir détails
                                        </a>
                                    </div>
                                </div>
                                <div class="p-4 flex-grow pb-2"> 
                                    <h4 class="font-bold mb-1"><?= htmlspecialchars($game['title']); ?></h4>
                                    <p class="text-zinc-400 text-sm mb-2"><?= htmlspecialchars($game['type']); ?></p>
                                    <p class="text-zinc-400 text-sm mb-1">
                                        Temps de jeu: <?= htmlspecialchars($game['temps_jeu'] ?? '0'); ?> heures
                                    </p>
                                    <p class="text-zinc-400 text-sm mb-2">
                                        Statut: <?= htmlspecialchars($game['status'] ?? 'Non défini'); ?>
                                    </p>
                                </div>
                                <div class="flex items-center px-4">
                                    <form method="POST" action="collectionProcess.php" class="inline-block">
                                        <input type="hidden" name="game_id" value="<?= $game['jeu_id']; ?>" >
                                        <?php if ($favoris->checkFavoris($game['jeu_id'], $_SESSION['user_id'])): ?>
                                            <button type="button" class="text-red-500 pr-72 transition-colors text-xl" onclick="alert('Ce jeu est déjà dans vos favoris')">
                                                <i class="fas fa-heart"></i>
                                            </button>
                                        <?php else: ?>
                                            <button type="submit" name="favorite_game" class="text-red-500 pr-72 hover:text-red-600 transition-colors text-xl" 
                                                    onclick="return confirm('Voulez-vous vraiment ajouter ce jeu à vos favoris ?')">
                                                <i class="far fa-heart"></i>
                                            </button>
                                        <?php endif; ?>
                                    </form>
                                    
                                    <button onclick="openModifyModal(<?= $game['jeu_id']; ?>, '<?= $game['temps_jeu']; ?>', '<?= $game['status']; ?>')" 
                                            class="text-blue-400 pr-4 hover:text-blue-600 transition-colors">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    
                                    <form method="POST" action="collectionProcess.php" class="inline-block" onsubmit="return confirm('Voulez-vous vraiment supprimer ce jeu ?')">
                                        <input type="hidden" name="game_id" value="<?= $game['jeu_id']; ?>" >
                                        <button type="submit" name="delete_game" class="text-red-400 hover:text-red-600 transition-colors">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>

                            </div>
                        <?php endforeach; ?>
                    </div>



                <?php else: ?>
                    <p>Aucune donnée trouvée dans votre bibliothèque.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div id="modifyModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
        <div class="bg-[#1e1b4b] p-6 rounded-lg shadow-xl">
            <h3 class="text-xl font-bold mb-4">Modifier les détails</h3>
            <form method="POST" action="collectionProcess.php" id="modifyForm">
                <input type="hidden" name="game_id" id="modalGameId">
                <div class="mb-4">
                    <label for="playtime" class="block text-gray-300 mb-2">Temps de jeu (en heures)</label>
                    <input type="time" name="temps_jeu" id="modalTempsJeu" class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600">
                </div>                          
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Statut</label>
                    <select name="status" id="modalStatus" class="w-full p-2 rounded bg-zinc-700 text-white">
                        <option value="En cours">En cours</option>
                        <option value="Terminé">Terminé</option>
                        <option value="Abandonné">Abandonné</option>
                    </select>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModifyModal()" 
                            class="px-4 py-2 bg-zinc-600 rounded hover:bg-zinc-700">
                        Annuler
                    </button>
                    <button type="submit" name="update_game" 
                            class="px-4 py-2 bg-blue-600 rounded hover:bg-blue-700">
                        Sauvegarder
                    </button>
                </div>
            </form>
        </div>
    </div>
    <?php include 'footer.php'?>
    <script>
    function openModifyModal(gameId, tempsJeu, status) {
        document.getElementById('modalGameId').value = gameId;
        document.getElementById('modalTempsJeu').value = tempsJeu;
        document.getElementById('modalStatus').value = status;
        document.getElementById('modifyModal').classList.remove('hidden');
        document.getElementById('modifyModal').classList.add('flex');
    }

    function closeModifyModal() {
        document.getElementById('modifyModal').classList.add('hidden');
        document.getElementById('modifyModal').classList.remove('flex');
    }
    </script>
</body>

</html>
