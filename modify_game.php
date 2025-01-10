<?php
session_start();
require_once 'connexion.php';
require_once 'GameClass.php';

$game = new Game();
if(isset($_GET['id'])) {
    $game->setJeu_id($_GET['id']);
    $gameInfo = $game->getSelectedGame();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameVault - Modifier un jeu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .gradient-text {
            background: linear-gradient(45deg, #FF6B6B, #4ECDC4);
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
    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="bg-[#1e1b4b]/30 backdrop-blur-sm p-8 rounded-lg border border-indigo-500/10 w-full max-w-2xl">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold">Modifier <span class="gradient-text">le jeu</span></h1>
                <a href="dashboard.php" class="text-zinc-400 hover:text-white transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </a>
            </div>

            <form action="gameProcess.php" method="POST" class="space-y-6">
                <input type="hidden" name="jeu_id" value="<?= htmlspecialchars($gameInfo['jeu_id']) ?>">
                
                <div>
                    <label class="block text-zinc-300 mb-2">Titre</label>
                    <input type="text" name="title" value="<?= htmlspecialchars($gameInfo['title']) ?>" required 
                           class="w-full px-4 py-3 rounded-lg bg-[#1e1b4b]/50 border border-zinc-700/50 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:ring-opacity-50 transition-all">
                </div>

                <div>
                    <label class="block text-zinc-300 mb-2">Description</label>
                    <textarea name="description" required rows="4"
                              class="w-full px-4 py-3 rounded-lg bg-[#1e1b4b]/50 border border-zinc-700/50 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:ring-opacity-50 transition-all"><?= htmlspecialchars($gameInfo['description']) ?></textarea>
                </div>

                <div>
                    <label class="block text-zinc-300 mb-2">Image (URL)</label>
                    <input type="text" name="image" value="<?= htmlspecialchars($gameInfo['image']) ?>" required 
                           class="w-full px-4 py-3 rounded-lg bg-[#1e1b4b]/50 border border-zinc-700/50 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:ring-opacity-50 transition-all">
                </div>

                <div>
                    <label class="block text-zinc-300 mb-2">Type</label>
                           <select name="type" value="<?= htmlspecialchars($gameInfo['type']) ?>" class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600">
                            <option value="Action">Action</option>
                            <option value="Aventure">Aventure</option>
                            <option value="Football">Football</option>
                            <option value="Battlefield">Battlefield</option>
                            <option value="Racing">Racing</option>
                            <option value="RPG">RPG</option>
                            <option value="Strategy">Strategy</option>
                            <option value="Puzzle">Puzzle</option>
                            <option value="Simulation">Simulation</option>
                            <option value="Sports">Sports</option>
                            <option value="Horror">Horror</option>
                            <option value="Fighting">Fighting</option>
                           </select>
                </div>

                <div>
                    <label class="block text-zinc-300 mb-2">Date de sortie</label>
                    <input type="date" name="date_sortie" value="<?= htmlspecialchars($gameInfo['date_sortie']) ?>" required 
                           class="w-full px-4 py-3 rounded-lg bg-[#1e1b4b]/50 border border-zinc-700/50 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:ring-opacity-50 transition-all">
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="dashboard.php" 
                       class="px-6 py-3 border border-zinc-700/50 rounded-lg hover:bg-zinc-700/30 transition-colors">
                        Annuler
                    </a>
                    <button type="submit" name="update" 
                            class="px-6 py-3 bg-indigo-600/90 hover:bg-indigo-500 rounded-lg transition-colors glow-effect">
                        Sauvegarder
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html> 